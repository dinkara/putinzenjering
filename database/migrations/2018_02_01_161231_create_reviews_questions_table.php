<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateReviewsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('reviews_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('review_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->tinyInteger('status')->default('1');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {     
        Schema::dropIfExists('reviews_questions');
    }
}
