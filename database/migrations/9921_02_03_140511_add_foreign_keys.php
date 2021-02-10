<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table -> foreign('user_id', 'ord-usr')
               -> references('id')
               -> on('users')
               -> onDelete('cascade');
            });

        Schema::table('order_pizza', function (Blueprint $table) {
            $table -> foreign('order_id', 'ord-piz')
                   -> references('id')
                   -> on('orders')
                   -> onDelete('cascade');
            $table -> foreign('pizza_id', 'piz-ord')
                   -> references('id')
                   -> on('pizzas');
            });

            Schema::table('drink_order', function (Blueprint $table) {
                $table -> foreign('drink_id', 'dri-ord')
                       -> references('id')
                       -> on('drinks')
                       -> onDelete('cascade');
                $table -> foreign('order_id', 'ord-dri')
                       -> references('id')
                       -> on('orders');
                });

        Schema::table('ingredient_pizza', function (Blueprint $table) {
            $table -> foreign('ingredient_id', 'ing-piz')
                   -> references('id')
                   -> on('ingredients')
                   -> onDelete('cascade');
            $table -> foreign('pizza_id', 'piz-ing')
                   -> references('id')
                   -> on('pizzas');
            });




        Schema::table('pizzas', function (Blueprint $table) {
            $table -> foreign('size_id', 'piz-siz')
               -> references('id')
               -> on('sizes')
               -> onDelete('cascade');
            });

        Schema::table('pizzas', function (Blueprint $table) {
                $table -> foreign('type_id', 'piz-typ')
                   -> references('id')
                   -> on('types')
                   -> onDelete('cascade');
            });

            Schema::table('addresses', function (Blueprint $table) {
                $table -> foreign('user_id', 'add-usr')
                   -> references('id')
                   -> on('users')
                   -> onDelete('cascade');
            });
    }


    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table -> dropForeign('ord-usr');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table -> dropForeign('add-usr');
        });

        Schema::table('order_pizza', function (Blueprint $table) {
            $table -> dropForeign('ord-piz');
            $table -> dropForeign('piz-ord');
        });

        Schema::table('drink_order', function (Blueprint $table) {
            $table -> dropForeign('dri-ord');
            $table -> dropForeign('ord-dri');
        });

        Schema::table('ingredient_pizza', function (Blueprint $table) {
            $table -> dropForeign('ing-piz');
            $table -> dropForeign('piz-ing');
        });

        Schema::table('pizzas', function (Blueprint $table) {
            $table -> dropForeign('piz-siz');
            $table -> dropForeign('piz-typ');
        });

    }
}
