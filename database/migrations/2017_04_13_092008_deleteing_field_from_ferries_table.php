<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteingFieldFromFerriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ferries', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->dropColumn('contact');
            $table->dropColumn('size');
            $table->dropColumn('address');
            $table->dropColumn('trip_id');
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
            $table->string('company_name');
            $table->string('contact');
            $table->tinyInteger('size');
            $table->string('address');
            $table->integer('trip_id');
        });
    }
}
