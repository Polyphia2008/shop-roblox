<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AccountRb;
use App\Models\Category;
use App\Models\ProductNick;
use App\Models\RateLevel;
use App\Security\SqlInjectionGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * ==================================================================
 *  TRANG CHỦ + CÁC TRANG TĨNH
 * ==================================================================
 *  BẢN GỐC (frontend/views/client/home.php) nối chuỗi trực tiếp:
 *
 *      $VCD->get_list("SELECT * FROM `mucrate` WHERE `status` = '1'");
 *      // và ở nick-game.php:
 *      ORDER BY $sortColumn $sortDirection     <-- INJECT ĐƯỢC
 *
 *  Cột và chiều sắp xếp KHÔNG THỂ bind bằng placeholder của PDO, nên đây
 *  là chỗ dễ bị SQL injection nhất. Giải pháp: dùng ALLOW-LIST cứng qua
 *  SqlInjectionGuard::column() / ::direction(). Bất kỳ giá trị nào không
 *  nằm trong danh sách sẽ bị thay bằng giá trị mặc định an toàn.
 * ==================================================================
 */
class HomeController extends Controller
{
    /** Các cột được phép sắp xếp — allow-list cứng, không mở rộng từ input */
    private const SORTABLE = ['price', 'robux', 'rate', 'id', 'created_at'];

    public function index(Request $request): View
    {
        $rates = RateLevel::query()
            ->where('status', '1')
            ->orderBy('code')
            ->get();

        /* Lọc theo mức rate — dùng binding, an toàn tuyệt đối */
        $rateCode = $request->string('rate_code')->trim()->value();

        $accounts = AccountRb::query()
            ->where('status', AccountRb::STATUS_ON_SALE)
            ->when($rateCode !== '', fn ($q) => $q->where('rate', (int) $rateCode))
            ->orderByDesc('id')
            ->paginate(24)
            ->withQueryString();

        return view('client.home', [
            'rates'      => $rates,
            'accounts'   => $accounts,
            'rateCode'   => $rateCode,
            'categories' => Category::query()->where('status', 'show')->orderBy('id')->get(),
        ]);
    }

    /**
     * Danh sách nick game — có tìm kiếm và sắp xếp.
     * Đây là bản an toàn của ORDER BY động trong nick-game.php.
     */
    public function nickGame(Request $request): View
    {
        /* Chuẩn hoá "sortBy" của giao diện cũ (price-low / price-high) */
        [$column, $direction] = match ($request->string('sortBy')->value()) {
            'price-low'  => ['price', 'asc'],
            'price-high' => ['price', 'desc'],
            'robux-high' => ['robux', 'desc'],
            default      => ['id', 'desc'],
        };

        /* Lớp bảo vệ thứ hai: dù match ở trên đã kín, vẫn ép qua allow-list */
        $column    = SqlInjectionGuard::column($column, self::SORTABLE, 'id');
        $direction = SqlInjectionGuard::direction($direction, 'desc');

        $keyword = $request->string('keyword')->trim()->value();

        $nicks = ProductNick::query()
            ->where('status', 'live')
            ->when($keyword !== '', function ($q) use ($keyword) {
                /* LIKE có binding — ký tự % và _ được escape để không phá pattern */
                $safe = addcslashes($keyword, '%_\\');
                $q->where('code', 'like', "%{$safe}%");
            })
            ->orderBy($column, $direction)
            ->paginate(24)
            ->withQueryString();

        return view('client.nick-game', [
            'nicks'      => $nicks,
            'keyword'    => $keyword,
            'sortBy'     => $request->string('sortBy')->value(),
            'categories' => Category::query()->where('status', 'show')->orderBy('id')->get(),
        ]);
    }

    /** Trang chi tiết chuyên mục nick */
    public function category(string $code): View
    {
        $category = Category::query()
            ->where('code', $code)          // binding, không nối chuỗi
            ->where('status', 'show')
            ->firstOrFail();

        $stock = ProductNick::query()
            ->where('chuyenmuc', $category->code)
            ->where('status', 'live')
            ->count();

        return view('client.buy', compact('category', 'stock'));
    }

    public function warrantyPolicy(): View
    {
        return view('client.warranty-policy');
    }

    public function useBot(): View
    {
        return view('client.use-bot');
    }

    public function useReport(): View
    {
        return view('client.use-report');
    }

    public function twoFactor(): View
    {
        return view('client.2fa');
    }

    public function checkBot(Request $request): View
    {
        return view('client.checkbot', [
            'notification' => $request->query('id') === 'noti',
        ]);
    }
}
