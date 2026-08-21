<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductNick;
use App\Security\SqlInjectionGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * ==================================================================
 *  QUẢN LÝ CHUYÊN MỤC + KHO NICK THƯỜNG
 * ==================================================================
 *  BẢN GỐC (ajaxs/admin/chuyen-muc.php, product.php):
 *
 *      INSERT INTO chuyenmuc (code, title, price)
 *      VALUES ('" . $_POST['code'] . "', '" . $_POST['title'] . "', ...)
 *
 *      DELETE FROM chuyenmuc WHERE code = '" . $_GET['code'] . "'
 *
 *  Lỗ hổng:
 *   1. Toàn bộ trường nối chuỗi -> inject, kể cả DELETE (rất nguy hiểm:
 *      payload  ' OR '1'='1  sẽ xoá TRẮNG bảng chuyên mục).
 *   2. Không kiểm tra trùng code -> dữ liệu rác.
 *   3. Xoá chuyên mục không kiểm tra nick còn tồn kho -> mất hàng.
 * ==================================================================
 */
class CatalogController extends Controller
{
    private const SORTABLE = ['id', 'price', 'buy', 'title', 'created_at'];

    /* ============================ CHUYÊN MỤC ============================ */

    public function categories(Request $request): View
    {
        $column    = SqlInjectionGuard::column($request->query('sort'), self::SORTABLE, 'id');
        $direction = SqlInjectionGuard::direction($request->query('dir'), 'desc');

        $categories = Category::query()
            ->withCount([
                'nicks as stock_count' => fn ($q) => $q->where('status', 'live'),
            ])
            ->orderBy($column, $direction)
            ->paginate(30)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'column', 'direction'));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $data = $request->validate([
            /* alpha_dash + unique: chống trùng và chống ký tự lạ trong code */
            'code'   => ['required', 'string', 'max:64', 'alpha_dash', 'unique:chuyenmuc,code'],
            'title'  => ['required', 'string', 'max:255'],
            'price'  => ['required', 'integer', 'min:0', 'max:1000000000'],
            'note'   => ['nullable', 'string', 'max:5000'],
            'logo'   => ['nullable', 'string', 'max:255', 'url'],
            'status' => ['required', 'in:show,hide'],
        ], [
            'code.unique'     => 'Mã chuyên mục này đã tồn tại.',
            'code.alpha_dash' => 'Mã chỉ gồm chữ, số, gạch ngang và gạch dưới.',
        ]);

        Category::query()->create($data);

        return back()->with('success', 'Đã thêm chuyên mục.');
    }

    public function updateCategory(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'code'   => [
                'required', 'string', 'max:64', 'alpha_dash',
                Rule::unique('chuyenmuc', 'code')->ignore($category->id),
            ],
            'title'  => ['required', 'string', 'max:255'],
            'price'  => ['required', 'integer', 'min:0', 'max:1000000000'],
            'note'   => ['nullable', 'string', 'max:5000'],
            'logo'   => ['nullable', 'string', 'max:255', 'url'],
            'status' => ['required', 'in:show,hide'],
        ]);

        /* Đổi code phải cập nhật luôn kho nick tham chiếu tới nó */
        DB::transaction(function () use ($category, $data): void {
            $oldCode = $category->code;

            $category->update($data);

            if ($oldCode !== $data['code']) {
                ProductNick::query()
                    ->where('chuyenmuc', $oldCode)
                    ->update(['chuyenmuc' => $data['code']]);
            }
        });

        return back()->with('success', 'Đã cập nhật chuyên mục.');
    }

    public function destroyCategory(Category $category): RedirectResponse
    {
        /* Chặn xoá khi còn hàng trong kho — bản gốc xoá thẳng, mất dữ liệu */
        $stock = ProductNick::query()
            ->where('chuyenmuc', $category->code)
            ->where('status', 'live')
            ->count();

        if ($stock > 0) {
            return back()->with('error', "Còn {$stock} nick trong kho, không thể xoá.");
        }

        $category->delete();

        return back()->with('success', 'Đã xoá chuyên mục.');
    }

    /* ============================== KHO NICK ============================= */

    public function nicks(Request $request): View
    {
        $column    = SqlInjectionGuard::column($request->query('sort'), ['id', 'code', 'created_at'], 'id');
        $direction = SqlInjectionGuard::direction($request->query('dir'), 'desc');

        $nicks = ProductNick::query()
            ->when($request->filled('chuyenmuc'), fn ($q) => $q->where('chuyenmuc', (string) $request->query('chuyenmuc')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', (string) $request->query('status')))
            ->when($request->filled('keyword'), function ($q) use ($request) {
                $safe = addcslashes($request->string('keyword')->trim()->value(), '%_\\');
                $q->where('code', 'like', "%{$safe}%");
            })
            ->orderBy($column, $direction)
            ->paginate(50)
            ->withQueryString();

        return view('admin.nicks.index', [
            'nicks'      => $nicks,
            'categories' => Category::query()->orderBy('title')->get(),
            'column'     => $column,
            'direction'  => $direction,
        ]);
    }

    /** Nhập kho hàng loạt: mỗi dòng "user|pass" hoặc "user" */
    public function storeNicks(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'chuyenmuc' => ['required', 'string', 'max:64', 'exists:chuyenmuc,code'],
            'data'      => ['required', 'string', 'max:500000'],
        ], [
            'chuyenmuc.exists' => 'Chuyên mục không tồn tại.',
        ]);

        $lines = collect(preg_split('/\r\n|\r|\n/', $data['data']))
            ->map(fn ($l) => trim((string) $l))
            ->filter()
            ->unique()
            ->values();

        if ($lines->isEmpty()) {
            return back()->with('error', 'Không có dòng dữ liệu hợp lệ.');
        }

        $now = now();

        $rows = $lines->map(function (string $line) use ($data, $request, $now): array {
            $parts = explode('|', $line, 2);

            return [
                'code'         => trim($parts[0]),
                'chuyenmuc'    => $data['chuyenmuc'],
                'note'         => isset($parts[1]) ? trim($parts[1]) : null,
                'status'       => 'live',
                'seller'       => $request->user()->email,
                'updated_time' => $now,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        })->all();

        /* insert theo lô, vẫn là prepared statement do query builder sinh ra */
        DB::transaction(function () use ($rows): void {
            foreach (array_chunk($rows, 500) as $chunk) {
                ProductNick::query()->insert($chunk);
            }
        });

        return back()->with('success', 'Đã nhập '.count($rows).' nick vào kho.');
    }

    public function destroyNick(ProductNick $nick): RedirectResponse
    {
        if ($nick->status !== 'live') {
            return back()->with('error', 'Nick đã bán, không thể xoá.');
        }

        $nick->delete();

        return back()->with('success', 'Đã xoá nick.');
    }
}
