<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('patient_id')->constrained('patients'); // Foreign key for patients table
            $table->foreignId('doctor_id')->constrained('doctors'); // Foreign key for doctors table
            $table->timestamp('appointment_date'); // Timestamp for appointment date
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled'); // Status column
            $table->text('description')->nullable(); // Nullable description
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
        Schema::dropIfExists('appointments');
    }
}
