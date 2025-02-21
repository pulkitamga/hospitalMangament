<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // Foreign key for doctors table
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
};
