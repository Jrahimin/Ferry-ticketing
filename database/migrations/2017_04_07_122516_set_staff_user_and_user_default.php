<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetStaffUserAndUserDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('status')->default(1)->change();
            $table->integer('admin')->default(0)->change();
            $table->integer('staff_user')->default(0)->change();
            $table->integer('user')->default(0)->change();
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
            $table->tinyInteger('status');
             $table->tinyInteger('admin');
              $table->tinyInteger('staff_user');
              $table->tinyInteger('user');
        });
    }
}
