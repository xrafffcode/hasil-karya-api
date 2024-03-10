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
        Schema::create('project_station_pivot', function (Blueprint $table) {
            $table->id();

            $table->uuid('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->uuid('station_id');
            $table->foreign('station_id')->references('id')->on('stations');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_station_pivot');
    }
};
