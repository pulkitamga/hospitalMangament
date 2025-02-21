<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->string('stud_id')->unique(); // Unique student ID
            $table->string('mrn')->unique(); // Unique medical record number
            $table->string('name');
            $table->string('gender');
            $table->date('birthday');
            $table->string('address')->nullable();
            $table->string('region')->nullable();
            $table->string('phone')->nullable();
            $table->string('nationality')->nullable();
            $table->string('bloodgroup')->nullable();
            $table->enum('status', ['admitted', 'discharged', 'pending'])->default('pending');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('block_id')->constrained('blocks');
            $table->string('dorm')->nullable();
            $table->integer('year')->nullable();
            $table->string('doctor')->nullable();
            $table->string('disease')->nullable();
            $table->timestamp('admit_date')->nullable();
            $table->timestamp('discharge_date')->nullable();
            $table->timestamps(); // Created_at, Updated_at
            $table->softDeletes(); // Soft Deletes column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
