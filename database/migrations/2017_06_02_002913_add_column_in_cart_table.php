<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->text('passenger_info')->nullable();
            $table->text('seat_selected_departure')->nullable();
            $table->text('seat_selected_destination')->nullable();
            $table->text('collector_info')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn('passenger_info');
            $table->dropColumn('seat_selected_departure');
            $table->dropColumn('seat_selected_destination');
            $table->dropColumn('collector_info');
            
        });
            
    }
}
