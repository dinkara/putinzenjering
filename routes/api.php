<?php

use Illuminate\Http\Request;

//Default auth routes
Route::post('login', 'Auth\AuthController@login');
Route::post('auth/facebook', 'Auth\AuthController@facebookAuth');
Route::post('auth/google', 'Auth\AuthController@googleAuth');
Route::post('register', 'Auth\AuthController@register');
Route::post('forgot/password', 'Auth\ForgotPasswordController@forgot');
Route::get('email/confirmation/{confirmation_code}', 'Auth\AuthController@confirmEmail');
Route::post('password/reset', 'Auth\ForgotPasswordController@resetPassword');


Route::middleware(['dinkoapi.auth', 'user.check.status'])->group(function (){
    Route::get('token/refresh', 'Auth\AuthController@getToken');
    Route::post('logout', 'Auth\AuthController@logout');    
    
    /*===================== CategoryController route section =====================*/
    Route::group(['prefix' => 'categories'], function(){
        Route::get('paginate', 'CategoryController@paginate');
        
        Route::get('{id}/orders', 'CategoryController@allOrders');

        Route::get('{id}/orders/paginate', 'CategoryController@paginatedOrders');



    });   

    Route::apiResource('categories', 'CategoryController', [
        'parameters' => [
            'categories' => 'id'
        ]
    ]);
    /* End CategoryController route section */
    
    /*===================== ImageController route section =====================*/
    Route::group(['prefix' => 'images'], function(){
        Route::get('paginate', 'ImageController@paginate');



    });   

    Route::apiResource('images', 'ImageController', [
        'parameters' => [
            'images' => 'id'
        ]
    ]);
    /* End ImageController route section */
    
    /*===================== LoadingController route section =====================*/
    Route::group(['prefix' => 'loadings'], function(){
        Route::get('paginate', 'LoadingController@paginate');
        
        Route::get('{id}/images', 'LoadingController@allImages');

        Route::get('{id}/images/paginate', 'LoadingController@paginatedImages');



    });   

    Route::apiResource('loadings', 'LoadingController', [
        'parameters' => [
            'loadings' => 'id'
        ]
    ]);
    /* End LoadingController route section */
    
    /*===================== OrderController route section =====================*/
    Route::group(['prefix' => 'orders'], function(){
        Route::get('paginate', 'OrderController@paginate');
        
        Route::get('{id}/reviews', 'OrderController@allReviews');

        Route::get('{id}/reviews/paginate', 'OrderController@paginatedReviews');
        
        Route::get('{id}/loadings', 'OrderController@allLoadings');

        Route::get('{id}/loadings/paginate', 'OrderController@paginatedLoadings');



    });   

    Route::apiResource('orders', 'OrderController', [
        'parameters' => [
            'orders' => 'id'
        ]
    ]);
    /* End OrderController route section */
    
    /*===================== ProjectController route section =====================*/
    Route::group(['prefix' => 'projects'], function(){
        Route::get('paginate', 'ProjectController@paginate');
        
        Route::get('{id}/orders', 'ProjectController@allOrders');

        Route::get('{id}/orders/paginate', 'ProjectController@paginatedOrders');
        
        Route::get('projects', 'ProjectController@allUsers');

        Route::get('projects/paginate', 'ProjectController@paginatedUsers');



    });   

    Route::apiResource('projects', 'ProjectController', [
        'parameters' => [
            'projects' => 'id'
        ]
    ]);
    /* End ProjectController route section */
    
    /*===================== QuestionController route section =====================*/
    Route::group(['prefix' => 'questions'], function(){
        Route::get('paginate', 'QuestionController@paginate');
        
        Route::get('{id}/questions', 'QuestionController@allReviews');

        Route::get('{id}/questions/paginate', 'QuestionController@paginatedReviews');



    });   

    Route::apiResource('questions', 'QuestionController', [
        'parameters' => [
            'questions' => 'id'
        ]
    ]);
    /* End QuestionController route section */
    
    /*===================== ReviewController route section =====================*/
    Route::group(['prefix' => 'reviews'], function(){
        Route::get('paginate', 'ReviewController@paginate');
        
        Route::get('{id}/questions', 'ReviewController@allQuestions');

        Route::get('{id}/questions/paginate', 'ReviewController@paginatedQuestions');
        
        Route::get('{id}/images', 'ReviewController@allImages');

        Route::get('{id}/images/paginate', 'ReviewController@paginatedImages');

        Route::post('{id}/questions/{question_id}', 'ReviewController@attachQuestion');

        Route::delete('{id}/questions/{question_id}', 'ReviewController@detachQuestion');

    });   

    Route::apiResource('reviews', 'ReviewController', [
        'parameters' => [
            'reviews' => 'id'
        ]
    ]);
    /* End ReviewController route section */
    
    /*===================== TruckController route section =====================*/
    Route::group(['prefix' => 'trucks'], function(){
        Route::get('paginate', 'TruckController@paginate');



    });   

    Route::apiResource('trucks', 'TruckController', [
        'parameters' => [
            'trucks' => 'id'
        ]
    ]);
    /* End TruckController route section */
    
    /*===================== UserController route section =====================*/
    Route::group(['prefix' => 'users'], function(){
        Route::get("/me", 'UserController@me');
        Route::put("/", 'UserController@update');
        
        Route::get('roles', 'UserController@allRoles');

        Route::get('roles/paginate', 'UserController@paginatedRoles');
        
        Route::get('social-networks', 'UserController@allSocialNetworks');

        Route::get('social-networks/paginate', 'UserController@paginatedSocialNetworks');
        
        Route::get('projects', 'UserController@allProjects');

        Route::get('projects/paginate', 'UserController@paginatedProjects');
        
        Route::get('reviews', 'UserController@allReviews');

        Route::get('reviews/paginate', 'UserController@paginatedReviews');
        
        Route::get('loadings', 'UserController@allLoadings');

        Route::get('loadings/paginate', 'UserController@paginatedLoadings');

        Route::post('roles/{role_id}', 'UserController@attachRole');
        Route::post('social-networks/{social_network_id}', 'UserController@attachSocialNetwork');
        Route::post('projects/{project_id}', 'UserController@attachProject');

        Route::delete('roles/{role_id}', 'UserController@detachRole');
        Route::delete('social-networks/{social_network_id}', 'UserController@detachSocialNetwork');
        Route::delete('projects/{project_id}', 'UserController@detachProject');

    });
    /* End UserController route section */


});
