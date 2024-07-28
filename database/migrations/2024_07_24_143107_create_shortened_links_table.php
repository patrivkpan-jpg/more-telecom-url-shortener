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
        Schema::create('shortened_links', function (Blueprint $table) {
            $table->id();
            $table->string('path', 10)->unique();
            $table->unsignedBigInteger('original_links_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('original_links_id')->references('id')->on('orginal_links');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortened_links');
    }
};
