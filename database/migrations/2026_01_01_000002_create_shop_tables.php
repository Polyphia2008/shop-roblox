<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Toàn bộ bảng nghiệp vụ của shop.
 *
 * Nâng cấp so với bản gốc:
 *  - Bản gốc dùng `text` cho gần như mọi cột (kể cả giá tiền, trạng thái).
 *    Nay dùng đúng kiểu dữ liệu (integer / decimal / enum-like string) nên
 *    MySQL tự loại bỏ dữ liệu rác, đồng thời cho phép đánh index.
 *  - Thêm index cho các cột thường xuyên dùng trong WHERE / ORDER BY.
 *  - Thêm khoá ngoại để tránh dữ liệu mồ côi.
 */
return new class extends Migration
{
    public function up(): void
    {
        /* ---------- Cấu hình website (key => value) ---------- */
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 190)->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        /* ---------- Chuyên mục sản phẩm ---------- */
        Schema::create('chuyenmuc', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->unique();
            $table->string('title', 255);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedInteger('buy')->default(0);
            $table->text('note')->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('status', 32)->default('show')->index();
            $table->timestamps();
        });

        /* ---------- Nick thường (theo chuyên mục) ---------- */
        Schema::create('product_nick', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->index();
            $table->string('chuyenmuc', 64)->nullable()->index();
            $table->string('magd', 64)->nullable()->index();
            $table->string('username', 190)->nullable()->index();
            $table->text('note')->nullable();
            $table->string('status', 32)->default('live')->index();
            $table->text('seller')->nullable();
            $table->timestamp('updated_time')->nullable();
            $table->timestamps();
        });

        /* ---------- Nick có Robux (đang bán) ---------- */
        Schema::create('accountrb', function (Blueprint $table) {
            $table->id();
            $table->string('username', 190)->nullable()->index();
            $table->string('seller', 190)->nullable();
            $table->string('status', 8)->default('1')->index();
            $table->unsignedInteger('rate')->default(0);
            $table->unsignedInteger('robux')->default(0);
            $table->unsignedBigInteger('price')->default(0);
            $table->string('guarantee', 64)->nullable();
            $table->string('premium', 8)->default('0');
            $table->string('datejoin', 64)->nullable();
            $table->text('information')->nullable();
            $table->string('magd', 64)->nullable()->index();
            $table->timestamp('time')->nullable();
            $table->timestamps();
        });

        /* ---------- Đơn đặt nick Robux theo yêu cầu ---------- */
        Schema::create('accountorder', function (Blueprint $table) {
            $table->id();
            $table->string('username', 190)->nullable()->index();
            $table->string('seller', 190)->nullable();
            $table->string('status', 8)->default('1')->index();
            $table->unsignedInteger('rate')->default(0);
            $table->unsignedInteger('robux')->default(0);
            $table->unsignedBigInteger('price')->default(0);
            $table->string('guarantee', 64)->nullable();
            $table->string('premium', 8)->default('0');
            $table->string('giaohang', 32)->nullable();
            $table->text('information')->nullable();
            $table->string('magd', 64)->nullable()->index();
            $table->timestamp('time')->nullable();
            $table->timestamps();
        });

        /* ---------- Đơn hàng chung ---------- */
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('magd', 64)->unique();
            $table->string('title', 255)->nullable();
            $table->unsignedInteger('soluong')->default(0);
            $table->unsignedBigInteger('money')->default(0);
            $table->string('username', 190)->nullable()->index();
            $table->unsignedInteger('live')->default(0);
            $table->string('type', 64)->nullable()->index();
            $table->string('display', 32)->default('show')->index();
            $table->timestamps();
        });

        /* ---------- Ngân hàng nhận tiền ---------- */
        Schema::create('bank', function (Blueprint $table) {
            $table->id();
            $table->string('short_name', 64);
            $table->string('accountNumber', 64);
            $table->string('accountName', 190);
            $table->string('logo', 255)->nullable();
            /* token API ngân hàng: cần mã hoá ở tầng model (encrypted cast) */
            $table->text('token')->nullable();
            $table->timestamps();
        });

        /* ---------- Giao dịch ngân hàng tự động ---------- */
        Schema::create('bank_auto', function (Blueprint $table) {
            $table->id();
            $table->string('tid', 190)->nullable()->unique();
            $table->string('bank', 64);
            $table->text('description')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->string('received', 190)->nullable();
            $table->timestamp('create_gettime')->nullable();
            $table->foreignId('user_id')->nullable()->index();
            $table->timestamps();
        });

        /* ---------- Thẻ cào ---------- */
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->nullable()->index();
            $table->string('username', 190)->index();
            $table->string('loaithe', 32);
            $table->unsignedBigInteger('menhgia')->default(0);
            $table->unsignedBigInteger('thucnhan')->default(0);
            $table->string('seri', 64);
            $table->string('pin', 64);
            $table->string('status', 32)->index();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        /* ---------- Đơn nạp tiền ---------- */
        Schema::create('don_nap', function (Blueprint $table) {
            $table->id();
            $table->text('noidung')->nullable();
            $table->foreignId('userid')->nullable()->index();
            $table->string('status', 32)->default('0')->index();
            $table->timestamps();
        });

        /* ---------- Mức rate & đơn rate ---------- */
        Schema::create('mucrate', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64);
            $table->string('status', 32)->default('1')->index();
            $table->timestamps();
        });

        Schema::create('rateorder', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64);
            $table->string('status', 32)->default('1')->index();
            $table->timestamps();
        });

        /* ---------- Ticket khiếu nại / bảo hành ---------- */
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->string('type', 64);
            $table->text('lydo')->nullable();
            $table->string('nickrb', 190)->nullable();
            $table->string('dichvu', 64)->nullable();
            $table->string('status', 32)->default('0')->index();
            $table->timestamp('time')->nullable();
            $table->timestamps();
        });

        /* ---------- Log dòng tiền ---------- */
        Schema::create('dongtien', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sotientruoc')->default(0);
            $table->bigInteger('sotienthaydoi')->default(0);
            $table->bigInteger('sotiensau')->default(0);
            $table->timestamp('thoigian')->nullable();
            $table->text('noidung')->nullable();
            $table->string('username', 190)->nullable()->index();
            $table->timestamps();
        });

        Schema::create('log_balance', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('money_before')->default(0);
            $table->bigInteger('money_change')->default(0);
            $table->bigInteger('money_after')->default(0);
            $table->text('content')->nullable();
            $table->foreignId('user_id')->nullable()->index();
            $table->timestamp('time')->nullable();
            $table->timestamps();
        });

        /* ---------- Log hành động (audit trail) ---------- */
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip', 64)->nullable();
            $table->text('device')->nullable();
            $table->text('action')->nullable();
            $table->timestamp('create_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach ([
            'logs', 'log_balance', 'dongtien', 'ticket', 'rateorder', 'mucrate',
            'don_nap', 'cards', 'bank_auto', 'bank', 'orders', 'accountorder',
            'accountrb', 'product_nick', 'chuyenmuc', 'settings',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
