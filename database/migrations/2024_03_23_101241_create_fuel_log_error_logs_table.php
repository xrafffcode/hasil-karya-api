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
        Schema::create('fuel_log_error_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->text('code')->nullable();
            $table->text('date')->nullable();
            $table->text('truck_id')->nullable();
            $table->text('heavy_vehicle_id')->nullable();
            $table->text('driver_id')->nullable();
            $table->text('station_id')->nullable();
            $table->text('gas_operator_id')->nullable();
            $table->text('fuel_type')->nullable();
            $table->text('volume')->nullable();
            $table->text('odometer')->nullable();
            $table->text('hourmeter')->nullable();
            $table->text('remarks')->nullable();
            $table->text('error_log')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('fuel_log_error_logs');
    }
};
