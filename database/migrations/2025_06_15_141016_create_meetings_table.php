<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->date('meeting_date');
            $table->timestamps();
        });

        Schema::create('meeting_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained(); // Add this line
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_continued')->default(false);
            $table->foreignId('continued_from_id')->nullable()->constrained('meeting_topics');
            $table->timestamps();
        });

        Schema::create('meeting_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_topic_id')->constrained()->cascadeOnDelete();
            $table->string('filename');
            $table->string('path');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
        Schema::dropIfExists('meeting_topics');
        Schema::dropIfExists('meeting_files');
    }
};
