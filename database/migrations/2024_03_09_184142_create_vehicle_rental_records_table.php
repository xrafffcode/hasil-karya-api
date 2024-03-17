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
        Schema::create('vehicle_rental_records', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('code');
            $table->uuid('truck_id')->nullable();
            $table->foreign('truck_id')->references('id')->on('trucks');
            $table->uuid('heavy_vehicle_id')->nullable();
            $table->foreign('heavy_vehicle_id')->references('id')->on('heavy_vehicles');
            $table->datetime('start_date');
            $table->integer('rental_duration');
            $table->decimal('rental_cost', 30, 8)->default(0);
            $table->boolean('is_paid')->default(false);
            $table->text('remarks')->nullable();
            $table->string('payment_proof_image')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_rental_records');
    }
};
