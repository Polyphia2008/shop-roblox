<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAuto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * ==================================================================
 *  QUẢN LÝ TÀI KHOẢN NGÂN HÀNG NHẬN TIỀN
 * ==================================================================
 *  BẢN GỐC (views/admin/ListBank.php, bank-edit.php, removeBank.php):
 *
 *      UPDATE bank SET token = '" . $_POST['token'] . "' WHERE id = '$id'
 *      DELETE FROM bank WHERE id = '" . $_GET['id'] . "'
 *
 *  Vấn đề:
 *   1. Nối chuỗi -> inject.
 *   2. `token` là API key đọc biến động số dư — lưu PLAINTEXT. Ai xem
 *      được DB hoặc bảng HTML admin là lấy được. Nay cast 'encrypted'
 *      trong model Bank, và view chỉ hiển thị dạng che (mask).
 * ==================================================================
 */
class BankController extends Controller
{
    public function index(): View
    {
        return view('admin.banks.index', [
            'banks' => Bank::query()->orderBy('id')->get(),

            /* Giao dịch tự động gần đây để đối soát */
            'recent' => BankAuto::query()->latest('id')->limit(30)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules(), $this->messages());

        Bank::query()->create($data);

        return back()->with('success', 'Đã thêm tài khoản ngân hàng.');
    }

    public function edit(Bank $bank): View
    {
        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank): RedirectResponse
    {
        $data = $request->validate($this->rules($bank), $this->messages());

        /* Để trống token = giữ token cũ, tránh vô tình xoá key đang chạy */
        if (blank($data['token'] ?? null)) {
            unset($data['token']);
        }

        $bank->update($data);

        return back()->with('success', 'Đã cập nhật tài khoản ngân hàng.');
    }

    public function destroy(Bank $bank): RedirectResponse
    {
        $bank->delete();

        return back()->with('success', 'Đã xoá tài khoản ngân hàng.');
    }

    private function rules(?Bank $bank = null): array
    {
        return [
            'short_name' => ['required', 'string', 'max:64'],
            'accountNumber' => [
                'required', 'string', 'max:64', 'regex:/^[0-9]+$/',
                $bank
                    ? Rule::unique('bank', 'accountNumber')->ignore($bank->id)
                    : Rule::unique('bank', 'accountNumber'),
            ],
            'accountName' => ['required', 'string', 'max:190'],
            'logo'        => ['nullable', 'string', 'max:255', 'url'],
            'token'       => ['nullable', 'string', 'max:2000'],
        ];
    }

    private function messages(): array
    {
        return [
            'accountNumber.regex'  => 'Số tài khoản chỉ gồm chữ số.',
            'accountNumber.unique' => 'Số tài khoản này đã tồn tại.',
            'logo.url'             => 'Logo phải là một URL hợp lệ.',
        ];
    }
}
