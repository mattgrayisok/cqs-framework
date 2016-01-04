<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique()->index();
            $table->string('email')->unique()->index();
            $table->string('password', 60);
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('timezone_id')->unsigned()->nullable();
            $table->integer('profile_image_id')->unsigned()->nullable();
            $table->integer('cover_image_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('timezone_id')->references('id')->on('timezones')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('profile_image_id')->references('id')->on('images')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cover_image_id')->references('id')->on('images')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropForeign('users_country_id_foreign');
            $table->dropForeign('users_timezone_id_foreign');
            $table->dropForeign('users_profile_image_id_foreign');
            $table->dropForeign('users_cover_image_id_foreign');

        });
        Schema::drop('users');
    }
}
