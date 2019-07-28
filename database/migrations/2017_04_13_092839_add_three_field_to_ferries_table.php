<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeFieldToFerriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ferries', function (Blueprint $table) {
            $table->tinyInteger('status');
            $table->string('captain_name');
            $table->integer('number_of_crew');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ferries', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('captain_name');
            $table->dropColumn('number_of_crew');
        });
    }
}
