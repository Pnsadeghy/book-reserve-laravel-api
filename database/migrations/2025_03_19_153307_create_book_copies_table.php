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
        Schema::create('book_copies', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('book_id')->constrained();
            $table->foreignUuid('branch_id')->constrained();

            $table->string('title');
            $table->boolean('is_visible')->default(false);
            $table->boolean('is_special')->default(false);
            $table->string('status');
            $table->string('condition');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_copies');
    }
};
