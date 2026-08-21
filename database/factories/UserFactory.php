<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 *
 * Bảng `users` dùng cột `username` (không phải `name` như scaffold mặc
 * định của Laravel), nên factory phải khai báo đúng cột — nếu không mọi
 * feature test sẽ chết vì "no such column: name".
 *
 * `level`, `money`, `banned` KHÔNG nằm trong $fillable của model (chống
 * leo thang đặc quyền qua mass assignment). Factory ghi được vì
 * Eloquent factory dùng forceCreate, nhưng request HTTP thì không.
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /** Hash một lần rồi tái dùng — bcrypt rất chậm, tính lại mỗi user sẽ làm test ì ạch. */
    protected static ?string $password = null;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username'          => fake()->userName(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'level'             => 0,
            'money'             => 0,
            'total_money'       => 0,
            'banned'            => false,
            'remember_token'    => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /** Quản trị viên (level >= 1) — dùng để test cổng chặn admin. */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => ['level' => 1]);
    }

    /** Tài khoản bị khoá — dùng để test middleware not.banned. */
    public function banned(): static
    {
        return $this->state(fn (array $attributes) => ['banned' => true]);
    }

    /** Có sẵn số dư để test mua hàng. */
    public function withMoney(int $amount): static
    {
        return $this->state(fn (array $attributes) => [
            'money'       => $amount,
            'total_money' => $amount,
        ]);
    }
}
