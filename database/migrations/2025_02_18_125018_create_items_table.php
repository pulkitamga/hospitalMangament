<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->string('name'); // Name of the item
            $table->string('manufacturer'); // Manufacturer of the item
            $table->integer('quantity'); // Quantity of the item
            $table->string('price'); // Price of the item
            $table->string('receipt_no')->unique(); // Unique receipt number
            $table->timestamps(); // Created_at, Updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
