<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Bảng ghi nhận sự kiện bảo mật.
 *
 * Mọi lần hệ thống phát hiện dấu hiệu tấn công (SQL Injection, XSS,
 * Path Traversal, brute-force, vượt rate-limit...) đều được ghi lại đây
 * để phục vụ điều tra và chặn IP.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_events', function (Blueprint $table) {
            $table->id();
            /* Loại tấn công: sql_injection | xss | traversal | rate_limit ... */
            $table->string('type', 64)->index();
            /* Mức độ: low | medium | high | critical */
            $table->string('severity', 16)->default('medium')->index();
            $table->string('ip', 64)->nullable()->index();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('method', 8)->nullable();
            $table->string('url', 2048)->nullable();
            /* Tên tham số và payload đã bị chặn (đã cắt ngắn) */
            $table->string('parameter', 190)->nullable();
            $table->text('payload')->nullable();
            $table->text('rule')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_events');
    }
};
