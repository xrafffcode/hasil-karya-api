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
        Schema::create('truck_rental_records', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('code');
            $table->uuid('truck_id');
            $table->foreign('truck_id')->references('id')->on('trucks');
            $table->datetime('start_date');
            $table->integer('rental_duration');
            $table->decimal('rental_cost', $precision = 16, $scale = 8)->default(0);
            $table->boolean('is_paid')->default(false);
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
        Schema::dropIfExists('truck_rental_records');
    }
};
