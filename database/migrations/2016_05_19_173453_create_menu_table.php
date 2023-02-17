<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('route');
            $table->string('class')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('order');
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->after('created_at');
            $table->foreign('updated_by')->references('id')->on('users')->after('updated_at');
            $table->dateTime('deleted_at')->nullable()->after('updated_by');
            $table->foreign('deleted_by')->references('id')->on('users')->after('deleted_at');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
