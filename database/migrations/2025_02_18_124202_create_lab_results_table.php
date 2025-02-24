<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('order_id')->constrained('lab_orders'); // Foreign key for lab_orders table
            $table->foreignId('test_id')->constrained('lab_tests'); // Foreign key for lab_tests table
            $table->string('result'); // Lab test result
            $table->enum('status', ['pending', 'completed'])->default('pending'); // Result status
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
        Schema::dropIfExists('lab_results');
    }
}
