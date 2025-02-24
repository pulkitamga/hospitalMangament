<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->string('name')->unique(); // Unique department name
            $table->text('description')->nullable(); // Nullable description
            $table->string('photo_path')->nullable(); // Nullable photo path
            $table->foreignId('hod_id')->constrained('hods'); // Foreign key for hods table
            $table->foreignId('block_id')->constrained('blocks'); // Foreign key for blocks table
            $table->enum('status', ['active', 'inactive'])->default('active'); // Department status
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
        Schema::dropIfExists('departments');
    }
}
