<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_leaves', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key referencing users table
            $table->date('from_date'); // Start date of the leave
            $table->date('to_date'); // End date of the leave
            $table->text('description')->nullable(); // Leave description (optional)
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending'); // Leave status
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
        Schema::dropIfExists('work_leaves');
    }
}
