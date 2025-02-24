<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_assigns', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key referencing users table
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade'); // Foreign key referencing items table
            $table->integer('quantity'); // Quantity of the item assigned
            $table->enum('status', ['assigned', 'returned'])->default('assigned'); // Status of the assignment
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
        Schema::dropIfExists('item_assigns');
    }
}
