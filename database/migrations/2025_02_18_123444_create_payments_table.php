<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('patient_id')->constrained('patients'); // Foreign key for patients table
            $table->foreignId('bill_id')->constrained('bills'); // Foreign key for bills table
            $table->string('amount'); // Amount as string
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid'); // Payment status
            $table->enum('mode', ['cash', 'card', 'cheque', 'online'])->default('cash'); // Payment mode
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
        Schema::dropIfExists('payments');
    }
}
