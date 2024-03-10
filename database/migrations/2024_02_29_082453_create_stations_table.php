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
        Schema::create('stations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('code');
            $table->string('province');
            $table->string('regency');
            $table->string('district');
            $table->string('subdistrict');
            $table->string('category');
            $table->uuid('material_id')->nullable();
            $table->foreign('material_id')->references('id')->on('materials');
            $table->string('is_active');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('stations');
    }
};
