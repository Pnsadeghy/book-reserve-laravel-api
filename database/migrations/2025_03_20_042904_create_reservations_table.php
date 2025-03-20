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
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('branch_id')->constrained();
            $table->foreignUuid('book_copy_id')->constrained();

            $table->integer('days_reserved');
            $table->string('status');

            $table->timestamp('expiration_date')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
