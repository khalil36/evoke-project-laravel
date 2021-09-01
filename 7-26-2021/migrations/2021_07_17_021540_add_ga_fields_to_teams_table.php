<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGaFieldsToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('ga_view_id')->default(0)->after('website');
            $table->string('ga_property_id')->default(0)->after('website');
            $table->string('ga_account_id')->default(0)->after('website');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('ga_account_id');
            $table->dropColumn('ga_property_id');
            $table->dropColumn('ga_view_id');
        });
    }
}
