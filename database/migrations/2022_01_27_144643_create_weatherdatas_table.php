<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weatherdatas', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('temperature');
            $table->string('weather');
            $table->date('datentime');
            $table->string('timeofday');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weatherdatas');
    }
}
