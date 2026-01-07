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
        Schema::create('config_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mosque_id');
            $table->string('background_before_adzan')->nullable();
            $table->string('background_iqama_time')->nullable();
            $table->string('background_prayer_silent')->nullable();
            $table->string('background_lecture')->nullable();
            $table->string('background_transaction')->nullable();
            $table->boolean('with_imsak')->default(0);
            $table->boolean('with_syuruq')->default(0);
            $table->string('calculation_method')->nullable();
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
        Schema::dropIfExists('config_players');
    }
};
