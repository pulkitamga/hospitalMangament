<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('patient_id')->constrained('patients'); // Foreign key for patients table
            $table->foreignId('doctor_id')->constrained('doctors'); // Foreign key for doctors table
            $table->string('symptoms'); // Symptoms of the patient
            $table->string('diagnosis'); // Diagnosis details
            $table->string('disease'); // Disease diagnosed
            $table->foreignId('lab_order_id')->nullable()->constrained('lab_orders'); // Foreign key for lab_orders table (nullable)
            $table->enum('status', ['pending', 'completed'])->default('pending'); // Visit status
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
        Schema::dropIfExists('visits');
    }
}
