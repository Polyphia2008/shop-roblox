<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ProductNick;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Dữ liệu mẫu để chạy thử giao diện (demo / preview).
 *
 * Lưu ý bảo mật khi seed:
 *  - `level`, `money`, `total_money`, `banned` KHÔNG nằm trong $fillable
 *    (chống mass assignment), nên phải gán tường minh rồi save() —
 *    không thể truyền qua create().
 *  - Mật khẩu để dạng thô ở đây; cast 'hashed' của model tự bcrypt.
 *    Tuyệt đối không seed sẵn hash yếu (sha1) như bản gốc.
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->seedUsers();
        $this->seedSettings();
        $this->seedCatalog();
    }

    private function seedUsers(): void
    {
        /* ---- Quản trị ---- */
        $admin = User::query()->firstOrNew(['email' => 'admin@demo.test']);
        $admin->username = 'admin';
        $admin->password = 'Admin@12345';   // cast 'hashed' -> bcrypt
        $admin->level    = 1;               // gán tường minh: ngoài $fillable
        $admin->banned   = false;
        $admin->save();

        /* ---- Khách thường, có sẵn số dư để thử mua hàng ---- */
        $user = User::query()->firstOrNew(['email' => 'user@demo.test']);
        $user->username    = 'khachhang';
        $user->password    = 'User@12345';
        $user->level       = 0;
        $user->banned      = false;
        $user->money       = 500_000;
        $user->total_money = 500_000;
        $user->save();

        /* ---- Tài khoản bị khoá: để thấy middleware not.banned hoạt động ---- */
        $banned = User::query()->firstOrNew(['email' => 'banned@demo.test']);
        $banned->username = 'bikhoa';
        $banned->password = 'Banned@12345';
        $banned->level    = 0;
        $banned->banned   = true;
        $banned->save();
    }

    private function seedSettings(): void
    {
        /* Chỉ seed các khoá nằm trong allow-list của SettingController. */
        $settings = [
            'title'        => 'Shop Roblox Demo',
            'description'  => 'Bản demo chạy thử giao diện sau khi viết lại trên Laravel 13.',
            'notification' => 'Đây là dữ liệu mẫu — không phải dữ liệu thật.',
            'maintenance'  => '0',
            'min_deposit'  => '10000',
        ];

        foreach ($settings as $name => $value) {
            Setting::query()->updateOrCreate(['name' => $name], ['value' => $value]);
        }
    }

    private function seedCatalog(): void
    {
        $categories = [
            ['code' => 'nick-random', 'title' => 'Nick Random Giá Rẻ',  'price' => 20_000],
            ['code' => 'nick-vip',    'title' => 'Nick VIP Có Robux',   'price' => 150_000],
        ];

        foreach ($categories as $data) {
            Category::query()->updateOrCreate(
                ['code' => $data['code']],
                $data + ['status' => 'show', 'note' => 'Hàng demo, thao tác không mất tiền thật.'],
            );

            /* Mỗi chuyên mục vài nick còn "live" để trang chủ có số lượng hiển thị. */
            for ($i = 1; $i <= 5; $i++) {
                ProductNick::query()->updateOrCreate(
                    ['code' => $data['code'].'-demo-'.$i],
                    [
                        'chuyenmuc' => $data['code'],
                        'status'    => 'live',
                        'note'      => 'Tài khoản demo số '.$i,
                    ],
                );
            }
        }
    }
}
