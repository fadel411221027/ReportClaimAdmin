<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('daily_reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->date('report_date');
        $table->boolean('is_approved')->default(false);
        $table->timestamp('approved_at')->nullable();
        $table->foreignId('approved_by')->nullable()->constrained('users');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
