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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('alias')->nullable();
            $table->string('name');
            $table->string('image_url');
            $table->time('open_time');
            $table->time('close_time');
            $table->string('url');
            $table->integer('review_count')->nullable();
            $table->float('rating')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('price');
            $table->string('phone');
            $table->string('display_phone');
            $table->json('transaction');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
