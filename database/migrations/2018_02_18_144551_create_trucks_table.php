<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('trucks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('plate',250)->unique('1');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {     
        Schema::dropIfExists('trucks');
    }
}
