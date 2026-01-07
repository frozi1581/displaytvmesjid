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
        Schema::create('mosques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('player_token')->unique();
            $table->string('logo_url')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('manager')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('storage_path')->nullable();
            $table->boolean('marketing_campaign')->default(false);
            $table->boolean('hide_phone')->default(false);
            $table->int('is_refresh')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->on('users')
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
        Schema::dropIfExists('mosques');
    }
};
