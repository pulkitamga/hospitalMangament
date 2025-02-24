<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beds', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('room_id')->constrained('rooms'); // Foreign key for rooms table
            $table->foreignId('patient_id')->nullable()->constrained('patients'); // Nullable foreign key for patients table
            $table->enum('status', ['allotted', 'available'])->default('available'); // Bed status
            $table->timestamp('alloted_time')->nullable(); // Nullable allotted time
            $table->timestamp('discharge_time')->nullable(); // Nullable discharge time
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
        Schema::dropIfExists('beds');
    }
}
