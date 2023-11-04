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
        Schema::create('business_locations', function (Blueprint $table) {
            $table->foreignId('business_id')->constrained('businesses');
            $table->string('address1');
            $table->string('address2');
            $table->string('address3');
            $table->string('city');
            $table->string('zip_code');
            $table->string('country');
            $table->string('state');
            $table->json('display_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_locations');
    }
};
