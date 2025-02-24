<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_information', function (Blueprint $table) {
            $table->id(); // Auto Incrementing ID
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key referencing users table
            $table->string('institution'); // Name of the institution
            $table->string('field'); // Field of study
            $table->string('level'); // Level of education (e.g., Bachelor's, Master's)
            $table->date('start_date'); // Start date of the education
            $table->date('end_date')->nullable(); // End date of the education (nullable)
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
        Schema::dropIfExists('education_information');
    }
}
