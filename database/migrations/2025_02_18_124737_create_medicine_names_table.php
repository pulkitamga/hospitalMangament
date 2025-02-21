<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_names', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->string('name')->unique(); // Unique name of the medicine
            $table->string('total'); // Total count or quantity
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
        Schema::dropIfExists('medicine_names');
    }
}
