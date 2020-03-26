<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId("user_id")->constrained();
            $table->foreignId("trip_id")->nullable()->constrained();
            $table->foreignId("departure_station_id")->references("id")->on("stations");
            $table->foreignId("arrival_station_id")->references("id")->on("stations");
            $table->unsignedInteger("seat");
            $table->unsignedFloat("price");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
