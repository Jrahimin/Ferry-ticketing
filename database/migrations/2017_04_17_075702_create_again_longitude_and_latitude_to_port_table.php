<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgainLongitudeAndLatitudeToPortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ports', function (Blueprint $table) {
            $table->double('latitude', 15, 8);
            $table->double('longitude', 15, 8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('ports', function (Blueprint $table) {
            $table->dropColumn('latitude', 15, 8);
            $table->dropColumn('longitude', 15, 8);
        });
    }
}
