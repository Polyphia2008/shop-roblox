<?php

declare(strict_types=1);

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ==================================================================
 *  VALIDATE YÊU CẦU MUA HÀNG
 * ==================================================================
 *  BẢN GỐC (ajaxs/client/muanick.php, ordernick.php):
 *
 *      $id  = xss($_POST['id']);
 *      $row = $VCD->get_row("SELECT * FROM `accountorder`
 *                            WHERE `id` = '$id' AND `status`='1'");
 *
 *  Hai lỗ hổng:
 *   1. $id nối thẳng vào SQL — xss() chỉ lọc thẻ HTML, KHÔNG chặn SQL.
 *      Payload  1' OR '1'='1  vẫn chạy được.
 *   2. Không kiểm tra kiểu — chuỗi bất kỳ cũng qua được.
 *
 *  Nay: 'integer' + 'exists' -> Laravel tự sinh prepared statement khi
 *  kiểm tra exists, và giá trị đã được ép về int trước khi vào truy vấn.
 * ==================================================================
 */
class PurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id'       => ['required', 'integer', 'min:1', 'exists:accountrb,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Thiếu mã tài khoản.',
            'id.integer'  => 'Mã tài khoản không hợp lệ.',
            'id.exists'   => 'Tài khoản này không tồn tại trong hệ thống.',
            'quantity.max' => 'Chỉ được mua tối đa 50 nick mỗi lần.',
        ];
    }

    /**
     * LƯU Ý QUAN TRỌNG: request KHÔNG hề nhận trường 'price'.
     * Bản gốc tin giá gửi từ client (`$_POST['price']`) nên khách có thể
     * sửa DevTools để mua giá 0đ. Giá luôn đọc lại từ DB trong
     * PurchaseService, đây là lý do trường giá bị loại bỏ hoàn toàn.
     */
    public function accountId(): int
    {
        return (int) $this->validated('id');
    }
}
