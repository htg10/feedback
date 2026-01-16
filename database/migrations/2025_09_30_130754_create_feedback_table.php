<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->string('mobile');
            $table->string('otp')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->enum('type', ['feedback', 'complaint']);
            $table->enum('list_type', ['main', 'jay', 'others'])->default('main');
            // Feedback fields
            $table->json('feedback_data')->nullable();
            $table->string('rating')->nullable();
            $table->string('rating_label')->nullable();
            $table->text('comments')->nullable();

            // Complaint fields
            $table->string('name')->nullable();
            $table->string('complaint_type')->nullable();
            $table->text('complaint_details')->nullable();
            $table->string('room')->nullable();
            $table->text('document')->nullable();
            $table->enum('status', ['pending', 'complete'])->default('pending');
            $table->string('user_remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
