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
        Schema::create('config_player_intervals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id');
            $table->float('interval_friday')->default(40.0);
            $table->float('interval_lecture')->default(1.0);
            $table->float('interval_transaction')->default(1.0);
            $table->float('interval_image')->default(1.0);
            $table->float('interval_video')->default(1.0);
            $table->float('interval_slider')->default(0.1);
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
        Schema::dropIfExists('config_player_intervals');
    }
};
