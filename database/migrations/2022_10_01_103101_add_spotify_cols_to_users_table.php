<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('spotify_id')->nullable();
            $table->string('spotify_avatar')->nullable();
            $table->string('spotify_profile_url')->nullable();
            $table->string('spotify_token')->nullable();
            $table->string('spotify_refresh_token')->nullable();
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
            $table->dropColumn('spotify_id');
            $table->dropColumn('spotify_avatar');
            $table->dropColumn('spotify_profile_url');
            $table->dropColumn('spotify_token');
            $table->dropColumn('spotify_refresh_token');
        });
    }
};
