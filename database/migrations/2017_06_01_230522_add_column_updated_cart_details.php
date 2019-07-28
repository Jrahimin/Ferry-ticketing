<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUpdatedCartDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->text('updated_cart_details')->nullable();
        });
    }

    
    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn('updated_cart_details');
        });
    }
}
