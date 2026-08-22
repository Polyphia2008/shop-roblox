<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RateLevel;
use App\Models\RateOrder;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * ==================================================================
 *  CẤU HÌNH HỆ THỐNG + MỨC RATE
 * ==================================================================
 *  BẢN GỐC (views/admin/Setting.php, ajaxs/admin/add_mucrate.php,
 *  remove_mucrate.php, rateorder.php):
 *
 *      UPDATE settings SET value = '" . $_POST[$k] . "' WHERE name = '$k'
 *
 *  Vấn đề:
 *   1. Vòng lặp ghi thẳng mọi khoá $_POST vào bảng settings, nối chuỗi
 *      -> vừa inject được, vừa cho phép tạo/ghi đè BẤT KỲ khoá cấu hình
 *      nào (kể cả khoá nội bộ). Nay dùng ALLOW-LIST khoá cố định.
 *   2. Token Telegram hardcode trong core/helpers.php -> nay lưu trong
 *      settings (cast encrypted) hoặc .env.
 * ==================================================================
 */
class SettingController extends Controller
{
    /**
     * ALLOW-LIST khoá cấu hình được phép sửa qua giao diện admin.
     * Khoá không nằm trong danh sách này sẽ bị bỏ qua hoàn toàn.
     */
    private const ALLOWED = [
        'title'           => ['nullable', 'string', 'max:190'],
        'description'     => ['nullable', 'string', 'max:500'],
        'notification'    => ['nullable', 'string', 'max:5000'],
        'logo'            => ['nullable', 'string', 'max:255'],
        'favicon'         => ['nullable', 'string', 'max:255'],
        'telegram_token'  => ['nullable', 'string', 'max:200'],
        'telegram_group'  => ['nullable', 'string', 'max:64'],
        'maintenance'     => ['nullable', 'in:0,1'],
        'min_deposit'     => ['nullable', 'integer', 'min:0', 'max:1000000000'],
        'warranty_policy' => ['nullable', 'string', 'max:20000'],
        'use_bot'         => ['nullable', 'string', 'max:20000'],
        'use_report'      => ['nullable', 'string', 'max:20000'],
        'guide_2fa'       => ['nullable', 'string', 'max:20000'],
    ];

    public function index(): View
    {
        return view('admin.settings.index', [
            'settings'   => Setting::query()->orderBy('name')->get()->keyBy('name'),
            'allowed'    => array_keys(self::ALLOWED),
            'rateLevels' => RateLevel::query()->orderBy('code')->get(),
            'rateOrders' => RateOrder::query()->orderBy('code')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        /* Chỉ validate + ghi các khoá có trong allow-list */
        $validated = $request->validate(self::ALLOWED);

        DB::transaction(function () use ($validated): void {
            foreach ($validated as $name => $value) {
                /* Setting::put dùng updateOrCreate -> prepared statement */
                Setting::put($name, $value);
            }
        });

        /* Xoá cache cấu hình để thay đổi có hiệu lực ngay */
        Setting::flush();

        return back()->with('success', 'Đã lưu cấu hình.');
    }

    /* ============================== MỨC RATE ============================= */

    public function storeRateLevel(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code'   => ['required', 'string', 'max:64', 'unique:mucrate,code'],
            'status' => ['required', 'in:0,1'],
        ], [
            'code.unique' => 'Mức rate này đã tồn tại.',
        ]);

        RateLevel::query()->create($data);

        return back()->with('success', 'Đã thêm mức rate.');
    }

    public function destroyRateLevel(RateLevel $rate): RedirectResponse
    {
        $rate->delete();

        return back()->with('success', 'Đã xoá mức rate.');
    }

    public function storeRateOrder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code'   => ['required', 'string', 'max:64', 'unique:rateorder,code'],
            'status' => ['required', 'in:0,1'],
        ], [
            'code.unique' => 'Mức rate order này đã tồn tại.',
        ]);

        RateOrder::query()->create($data);

        return back()->with('success', 'Đã thêm mức rate order.');
    }

    public function destroyRateOrder(RateOrder $rate): RedirectResponse
    {
        $rate->delete();

        return back()->with('success', 'Đã xoá mức rate order.');
    }
}
