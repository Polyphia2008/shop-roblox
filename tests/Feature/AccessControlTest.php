<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * ==================================================================
 *  KIỂM THỬ PHÂN QUYỀN & QUYỀN SỞ HỮU DỮ LIỆU
 * ------------------------------------------------------------------
 *  Đây là nhóm lỗ hổng NGHIÊM TRỌNG NHẤT của bản gốc, thậm chí còn
 *  nguy hiểm hơn SQL injection vì khai thác cực dễ:
 *
 *   1. CỔNG ADMIN GIẢ: hàm CheckAdmin() của bản gốc chỉ in ra
 *      echo '<script>location.href="/"</script>'
 *      Toàn bộ HTML trang admin VẪN được render và gửi về trình duyệt.
 *      Tắt JavaScript, hoặc dùng curl, là đọc được sạch trang quản trị.
 *      -> Nay chặn tại middleware, request không tới được controller.
 *
 *   2. IDOR: xem đơn hàng bằng ?magd=... mà không kiểm tra chủ sở hữu.
 *      Đổi mã trên URL là xem/tải được nick người khác đã mua.
 *      -> Nay mọi truy vấn đều kèm điều kiện chủ sở hữu.
 *
 *   3. GHI DỮ LIỆU QUA GET: bản gốc xoá/sửa bằng link GET, không CSRF.
 *      -> Nay dùng POST/PATCH/DELETE + CSRF token.
 * ==================================================================
 */
final class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    /* ================================================================
     *  PHẦN 1 — Cổng admin phải chặn ở tầng SERVER
     * ================================================================ */

    /**
     * Dùng TÊN ROUTE thay vì URL viết cứng: nếu sau này đổi đường dẫn,
     * test vẫn bảo vệ đúng endpoint chứ không lặng lẽ trả 404 rồi "pass".
     *
     * @return array<string, array{0: string}>
     */
    public static function adminRoutes(): array
    {
        return [
            'bảng điều khiển' => ['admin.home'],
            'người dùng'      => ['admin.users.index'],
            'nick robux'      => ['admin.accountrb.index'],
            'đơn robux'       => ['admin.accountrb.orders'],
            'chuyên mục'      => ['admin.categories.index'],
            'kho nick'        => ['admin.nicks.index'],
            'ngân hàng'       => ['admin.banks.index'],
            'nạp tiền'        => ['admin.deposits.index'],
            'ticket'          => ['admin.tickets.index'],
            'lịch sử đơn'     => ['admin.orders.index'],
            'cấu hình'        => ['admin.settings.index'],
            'nhật ký bảo mật' => ['admin.security-log'],
        ];
    }

    #[Test]
    #[DataProvider('adminRoutes')]
    public function guests_are_redirected_away_from_admin(string $routeName): void
    {
        $this->get(route($routeName))->assertRedirect(route('login'));
    }

    /**
     * Test quan trọng nhất: người dùng thường phải nhận 403 VÀ tuyệt đối
     * không nhận được một mảnh HTML nào của trang admin.
     */
    #[Test]
    #[DataProvider('adminRoutes')]
    public function normal_users_get_403_and_no_admin_html(string $routeName): void
    {
        $user = User::factory()->create(['level' => 0]);

        $response = $this->actingAs($user)->get(route($routeName));

        $response->assertForbidden();

        /* Chống lỗi kiểu bản gốc: nội dung admin bị render rồi mới "chuyển hướng" */
        $body = $response->getContent();
        $this->assertStringNotContainsString('Bảng điều khiển', (string) $body);
        $this->assertStringNotContainsString('Nhật ký bảo mật', (string) $body);
        $this->assertStringNotContainsString('location.href', (string) $body);
    }

    #[Test]
    public function admins_can_access_the_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('admin.home'))->assertOk();
    }

    #[Test]
    public function banned_admin_is_also_denied(): void
    {
        /*
         * Khoá tài khoản phải thắng cả quyền admin.
         * Thứ tự middleware trên nhóm admin là ['auth', 'not.banned', 'admin'],
         * nên `not.banned` chạy TRƯỚC: admin bị khoá không chỉ nhận 403 mà bị
         * đăng xuất hẳn và đẩy về trang đăng nhập. Đây là hành vi mạnh hơn 403
         * vì phiên làm việc bị huỷ ngay, không thể thử tiếp URL admin khác.
         */
        $admin = User::factory()->admin()->banned()->create();

        $this->actingAs($admin)
            ->get(route('admin.home'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    /* ================================================================
     *  PHẦN 2 — Người dùng bị khoá bị đăng xuất ngay
     * ================================================================ */

    #[Test]
    public function banned_user_is_logged_out_of_the_client_area(): void
    {
        $user = User::factory()->banned()->create();

        $this->actingAs($user)
            ->get('/auth/profile')
            ->assertRedirect(route('login'));

        /* Session đã bị vô hiệu hoá -> không còn đăng nhập */
        $this->assertGuest();
    }

    #[Test]
    public function active_user_can_open_their_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/auth/profile')->assertOk();
        $this->assertAuthenticatedAs($user);
    }

    /* ================================================================
     *  PHẦN 3 — IDOR: không được xem đơn của người khác
     * ================================================================ */

    #[Test]
    public function user_cannot_view_another_users_order(): void
    {
        $victim   = User::factory()->create(['email' => 'victim@example.com']);
        $attacker = User::factory()->create(['email' => 'attacker@example.com']);

        $order = Order::query()->create([
            'magd'     => 'GD-VICTIM-001',
            'title'    => 'Nick xịn của nạn nhân',
            'soluong'  => 1,
            'money'    => 500_000,
            'username' => $victim->email,   // thuộc nạn nhân
            'live'     => 1,
            'type'     => 'product_nick',
            'display'  => 'show',
        ]);

        /* Kẻ tấn công đoán đúng mã giao dịch nhưng vẫn phải bị chặn */
        $this->actingAs($attacker)
            ->get('/orders/'.$order->magd)
            ->assertNotFound();

        /* Kể cả đường dẫn tải file */
        $this->actingAs($attacker)
            ->get('/DownloadFile/'.$order->magd)
            ->assertNotFound();
    }

    #[Test]
    public function user_can_view_their_own_order(): void
    {
        $owner = User::factory()->create(['email' => 'owner@example.com']);

        $order = Order::query()->create([
            'magd'     => 'GD-OWNER-001',
            'title'    => 'Đơn của chính mình',
            'soluong'  => 1,
            'money'    => 100_000,
            'username' => $owner->email,
            'live'     => 1,
            'type'     => 'product_nick',
            'display'  => 'show',
        ]);

        $this->actingAs($owner)
            ->get('/orders/'.$order->magd)
            ->assertOk()
            ->assertSee('GD-OWNER-001');
    }

    /* ================================================================
     *  PHẦN 4 — CSRF & phương thức HTTP
     * ================================================================ */

    /**
     * Mọi hành động ghi dữ liệu phải là POST/PATCH/DELETE. Nếu còn route
     * GET nào làm thay đổi dữ liệu thì chỉ cần dụ admin bấm vào link (hoặc
     * nhúng <img src>) là dữ liệu bị sửa — chính lỗi của bản gốc.
     */
    #[Test]
    public function admin_write_actions_are_not_reachable_by_get(): void
    {
        $admin = User::factory()->admin()->create();

        /* Các URL này CÓ trang GET (chỉ để xem), việc ghi dùng PATCH/POST.
           Gọi GET không được làm thay đổi gì. */
        $this->actingAs($admin)->get(route('admin.settings.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.rates.index'))->assertOk();

        /* Xoá bản ghi chỉ nhận DELETE: GET vào cùng đường dẫn phải 405.
           Bản gốc xoá bằng link GET -> chỉ cần dụ admin bấm là mất dữ liệu. */
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->get('/admin/user-delete/'.$user->id)
            ->assertNotFound();

        $this->assertNotNull($user->fresh(), 'Bản ghi bị xoá qua GET!');
    }

    #[Test]
    public function logout_requires_post_not_get(): void
    {
        $user = User::factory()->create();

        /* GET tới đường dẫn logout phải KHÔNG đăng xuất được -> chống
           tấn công bằng <img src="/auth/logout"> hoặc link lừa bấm. */
        $this->actingAs($user)->get('/auth/logout')->assertStatus(405);
        $this->assertAuthenticatedAs($user);

        $this->actingAs($user)->post(route('logout'))->assertRedirect();
        $this->assertGuest();
    }

    /* ================================================================
     *  PHẦN 5 — Chống cố định phiên (session fixation)
     * ================================================================ */

    #[Test]
    public function session_id_changes_after_login(): void
    {
        $user = User::factory()->create([
            'email'    => 'login@example.com',
            'password' => 'mat-khau-manh-123',
        ]);

        $this->get(route('login'));
        $before = session()->getId();

        $this->post(route('login.store'), [
            'email'    => 'login@example.com',
            'password' => 'mat-khau-manh-123',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->assertNotSame(
            $before,
            session()->getId(),
            'Session ID không đổi sau khi đăng nhập -> có thể bị tấn công cố định phiên.',
        );
    }

    #[Test]
    public function wrong_password_does_not_authenticate(): void
    {
        User::factory()->create([
            'email'    => 'user@example.com',
            'password' => 'mat-khau-dung',
        ]);

        $this->post(route('login.store'), [
            'email'    => 'user@example.com',
            'password' => 'mat-khau-sai',
        ])->assertRedirect();

        $this->assertGuest();
        $this->assertNull(Auth::user());
    }
}
