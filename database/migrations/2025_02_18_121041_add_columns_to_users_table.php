<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'image')) {
            $table->string('image')->nullable(); // Nullable Image column
        }
        if (!Schema::hasColumn('users', 'email_verified_at')) {
            $table->timestamp('email_verified_at')->nullable(); // Nullable email_verified_at column
        }
        if (!Schema::hasColumn('users', 'role_id')) {
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade'); // Foreign key with roles table
        }
        if (!Schema::hasColumn('users', 'remember_token')) {
            $table->rememberToken(); // Remember Token column
        }
        if (!Schema::hasColumn('users', 'deleted_at')) {
            $table->softDeletes(); // Soft Deletes column
        }
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the added columns if migration is rolled back
            $table->dropColumn('image');
            $table->dropColumn('email_verified_at');
            $table->dropForeign(['role_id']);
            $table->dropColumn('remember_token');
            $table->dropSoftDeletes();
        });
    }
}
