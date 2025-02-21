<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_requests', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key referencing users table
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade'); // Foreign key referencing items table
            $table->integer('quantity'); // Quantity of the item requested
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status of the request
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
        Schema::dropIfExists('item_requests');
    }
}
