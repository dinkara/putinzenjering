<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['is.admin'])->group(function (){
    Route::group(['prefix' => 'admin'], function(){

        /*===================== ReviewController route section =====================*/
        Route::group(['prefix' => 'reviews'], function(){                   

            Route::get('{id}/pdf', 'Admin\ReviewController@pdf');                                       

        });
        /* End ReviewController route section */
    });
});

//Route::get("{id}/pdf", 'ReviewController@pdf');