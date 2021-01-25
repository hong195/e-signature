<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAditionalColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function(Blueprint $table) {
            $table->string('address')->after('name')->nullable();
            $table->string('website')->after('name')->nullable();
            $table->string('email')->after('name')->nullable();
        });

        Schema::table('users', function(Blueprint $table) {
            $table->string('phone')->after('surname')->nullable();
            $table->string('email')->after('surname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function(Blueprint $table) {
           $table->dropColumn(['website', 'address', 'email']);
        });

        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn(['email','phone']);
        });
    }
}
