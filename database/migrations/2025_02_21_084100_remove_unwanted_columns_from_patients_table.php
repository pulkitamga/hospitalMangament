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
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['stud_id', 'mrn', 'block_id', 'dorm', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('stud_id')->unique();
            $table->string('mrn')->unique();
            $table->foreignId('block_id')->constrained('blocks');
            $table->string('dorm')->nullable();
            $table->integer('year')->nullable();
        });
    }
};
