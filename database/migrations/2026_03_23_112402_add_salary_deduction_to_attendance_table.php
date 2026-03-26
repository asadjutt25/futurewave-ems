<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->decimal('salary_deduction', 10, 2)->default(0)->after('notes');
            $table->decimal('daily_salary', 10, 2)->nullable()->after('salary_deduction');
        });
    }

    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropColumn(['salary_deduction', 'daily_salary']);
        });
    }
};