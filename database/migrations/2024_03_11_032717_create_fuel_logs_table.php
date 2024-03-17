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
        Schema::create('fuel_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('code');
            $table->datetime('date');
            $table->uuid('truck_id')->nullable();
            $table->foreign('truck_id')->references('id')->on('trucks');
            $table->uuid('heavy_vehicle_id')->nullable();
            $table->foreign('heavy_vehicle_id')->references('id')->on('heavy_vehicles');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->uuid('station_id');
            $table->foreign('station_id')->references('id')->on('stations');
            $table->uuid('gas_operator_id');
            $table->foreign('gas_operator_id')->references('id')->on('gas_operators');
            $table->string('fuel_type');
            $table->decimal('volume', 30, 8)->default(0);
            $table->decimal('odometer', 30, 8)->default(0);
            $table->decimal('hourmeter', 30, 8)->default(0);
            $table->text('remarks')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('fuel_logs');
    }
};
