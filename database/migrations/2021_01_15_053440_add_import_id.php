<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImportId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('import_id')->index()->after('id')->nullable();
            $table->integer('position')->index()->after('name')->nullable();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->integer('import_id')->index()->after('id')->nullable();
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
            $table->dropColumn('import_id');
            $table->dropColumn('position');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('import_id');
        });
    }
}
