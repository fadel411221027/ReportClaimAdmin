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
    Schema::create('task_categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->boolean('has_dor_date')->default(false);
        $table->boolean('has_batch')->default(false);
        $table->boolean('has_claim')->default(false);
        $table->boolean('has_time_range')->default(false);
        $table->boolean('has_sheets')->default(false);
        $table->boolean('has_email')->default(false);
        $table->boolean('has_form')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_categories');
    }
};
