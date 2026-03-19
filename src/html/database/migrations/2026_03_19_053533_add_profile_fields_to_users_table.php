<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('postal_code')->nullable()->after('password');
            $table->string('address')->nullable()->after('postal_code');
            $table->string('building')->nullable()->after('address');
            $table->string('profile_image')->nullable()->after('building');
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
            $table->dropColumn(['postal_code', 'address', 'building', 'profile_image']);
        });
    }
}
