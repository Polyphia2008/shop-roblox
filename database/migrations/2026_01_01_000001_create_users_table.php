<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Bảng `users`.
 *
 * Nâng cấp so với bản gốc (legacy/sellgame.sql):
 *  - `password` dùng bcrypt/argon2 (60+ ký tự) thay cho sha1 không muối.
 *  - `email` là UNIQUE + có index -> chống trùng tài khoản và tăng tốc tra cứu.
 *  - `token` UNIQUE, dùng cho remember-token / API token.
 *  - `money`, `total_money` chuyển sang bigInteger để tránh tràn số.
 *  - Thêm cột chuẩn Laravel: email_verified_at, remember_token, timestamps.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100)->nullable()->index();
            $table->string('email', 190)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedTinyInteger('level')->default(0)->index();
            $table->string('token', 100)->nullable()->unique();
            $table->string('ip', 64)->nullable();
            $table->text('device')->nullable();
            $table->string('otp', 16)->nullable();
            $table->bigInteger('money')->default(0);
            $table->bigInteger('total_money')->default(0);
            $table->bigInteger('ck_user')->default(0);
            $table->boolean('banned')->default(false)->index();
            $table->unsignedBigInteger('time_request')->default(0);
            $table->unsignedBigInteger('time_session')->default(0);
            $table->string('telegram', 100)->nullable();
            $table->string('bank', 190)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 190)->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
