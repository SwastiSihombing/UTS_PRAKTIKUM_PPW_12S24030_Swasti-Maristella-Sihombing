<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('category_id')->foreign();
            $table->varchar('asset_code', 20)->unique();
            $table->varchar('name', 150)->unique();
            $table->txt('spesification');
            $table->string('condition');
            $table->string('status');
            $table->integer('dailyy_rental_fee');
            $table->varchar('image_path', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
