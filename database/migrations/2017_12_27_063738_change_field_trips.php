<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function(Blueprint $table) {
            $table->dropColumn('departure_date');
            $table->dropColumn('departure_time');
            $table->dateTime('departure_date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function(Blueprint $table) {
            $table->date('departure_date');
            $table->time('departure_time');
            $table->dropColumn('departure_date_time');
        });
    }
}
