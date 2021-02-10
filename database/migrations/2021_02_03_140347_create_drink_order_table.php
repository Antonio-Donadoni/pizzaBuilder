<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drink_order', function (Blueprint $table) {
            $table->id();

            $table -> bigInteger('drink_id') -> unsigned(); // chiave esterna
            $table -> bigInteger('order_id') -> unsigned(); // chiave esterna

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
        Schema::dropIfExists('drink_order');
    }
}
