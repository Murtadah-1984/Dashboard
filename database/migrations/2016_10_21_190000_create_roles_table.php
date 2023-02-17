<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name');
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
        Schema::drop('roles');
    }
}
