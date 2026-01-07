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
        Schema::create('config_player_shows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id');
            $table->boolean('show_main')->default(1);
            $table->boolean('show_transaction')->default(0);
            $table->boolean('show_lecture')->default(0);
            $table->boolean('show_video')->default(0);
            $table->boolean('show_image')->default(0);
            $table->timestamps();

            $table->foreign('mosque_id')
                ->on('mosques')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_player_shows');
    }
};
