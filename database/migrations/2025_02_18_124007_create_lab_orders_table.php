<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_orders', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('visit_id')->constrained('visits'); // Foreign key for visits table
            $table->foreignId('patient_id')->constrained('patients'); // Foreign key for patients table
            $table->enum('status', ['pending', 'completed'])->default('pending'); // Lab order status
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
        Schema::dropIfExists('lab_orders');
    }
}
