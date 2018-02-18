<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Support\Enum\UserStatuses;


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
            $table->timestamps();
            $table->string('email',30)->unique();
            $table->string('password')->nullable();
            $table->string('confirmation_code')->nullable();
            $table->enum('status' ,UserStatuses::all())->default(UserStatuses::NEW);
            $table->timestamp('password_updated')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->softDeletes();
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {     
        Schema::dropIfExists('users');
    }
}
