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
        Schema::create('trucks', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('code');
            $table->string('brand');
            $table->string('model');
            $table->decimal('capacity', 16, 8)->default(0);
            $table->string('production_year');
            $table->uuid('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->boolean('is_active');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trucks');
    }
};
