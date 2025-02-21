<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->string('name'); // Name of the medicine
            $table->string('quantity'); // Quantity available
            $table->string('price'); // Price of the medicine
            $table->string('manufacturer'); // Manufacturer of the medicine
            $table->date('expiry_date'); // Expiry date of the medicine
            $table->string('category'); // Category of the medicine
            $table->enum('status', ['available', 'out_of_stock'])->default('available'); // Medicine stock status
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
        Schema::dropIfExists('medicines');
    }
}
