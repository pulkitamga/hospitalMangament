<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('department_id')->constrained('departments'); // Foreign key for departments table
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available'); // Room status
            $table->enum('type', ['ward', 'private', 'semi-private', 'general'])->default('general'); // Room type
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
        Schema::dropIfExists('rooms');
    }
}
