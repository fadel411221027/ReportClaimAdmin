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
        Schema::create('report_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_report_id')->constrained()->cascadeOnDelete();
            $table->foreignId('task_category_id')->constrained();
            $table->date('task_date')->nullable(); // For DOR dates
            $table->integer('batch_count')->nullable(); //batch
            $table->integer('claim_count')->nullable(); //klaim
            $table->time('start_time')->nullable(); //mulai jam
            $table->time('end_time')->nullable(); //sampai jam
            $table->integer('sheet_count')->nullable(); //lembar
            $table->integer('email')->nullable();//email
            $table->integer('form')->nullable();//form
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_tasks');
    }
};
