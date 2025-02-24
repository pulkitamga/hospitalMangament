<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('birth_reports', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('patient_id')->constrained('patients'); // Foreign key for patients table
            $table->foreignId('doctor_id')->constrained('doctors'); // Foreign key for doctors table
            $table->text('description'); // Description of the birth report
            $table->string('gender'); // Gender of the baby
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
        Schema::dropIfExists('birth_reports');
    }
}
