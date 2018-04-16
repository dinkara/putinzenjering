<?php

use Illuminate\Http\Request;

//Default auth routes
Route::post('login', 'Auth\AuthController@login');
//Route::post('auth/facebook', 'Auth\AuthController@facebookAuth');
//Route::post('auth/google', 'Auth\AuthController@googleAuth');
//Route::post('register', 'Auth\AuthController@register');
Route::post('forgot/password', 'Auth\ForgotPasswordController@forgot');
Route::get('email/confirmation/{confirmation_code}', 'Auth\AuthController@confirmEmail');
Route::post('password/reset', 'Auth\ForgotPasswordController@resetPassword');


Route::middleware(['dinkoapi.auth', 'user.check.status'])->group(function (){
    Route::get('token/refresh', 'Auth\AuthController@getToken');
    Route::post('logout', 'Auth\AuthController@logout');    
    
    Route::middleware(['is.admin'])->group(function (){
        Route::group(['prefix' => 'admin'], function(){
            
            /*===================== RoleController route section =====================*/
            Route::group(['prefix' => 'roles'], function(){
                Route::get("/", 'Admin\RoleController@index');
            });
            /* End RoleController route section */
            
            /*===================== UserController route section =====================*/
            Route::group(['prefix' => 'users'], function(){
            
                Route::get("/", 'Admin\UserController@index');
                Route::post("/", 'Admin\UserController@store');
                Route::get("paginate", 'Admin\UserController@paginate');
                
                Route::group(['prefix' => '{id}'], function(){ 
                    
                    Route::get("/", 'Admin\UserController@show');
                    Route::put("/", 'Admin\UserController@update');
                    Route::delete("/", 'Admin\UserController@destroy');

                    Route::get('roles', 'Admin\UserController@allRoles');

                    Route::get('roles/paginate', 'Admin\UserController@paginatedRoles');

                    Route::get('social-networks', 'Admin\UserController@allSocialNetworks');

                    Route::get('social-networks/paginate', 'Admin\UserController@paginatedSocialNetworks');

                    Route::get('projects', 'Admin\UserController@allProjects');

                    Route::get('projects/paginate', 'Admin\UserController@paginatedProjects');

                    Route::get('reviews', 'Admin\UserController@allReviews');

                    Route::get('reviews/paginate', 'Admin\UserController@paginatedReviews');

                    Route::get('loadings', 'Admin\UserController@allLoadings');

                    Route::get('loadings/paginate', 'Admin\UserController@paginatedLoadings');

                    Route::post('roles/{role_id}', 'Admin\UserController@attachRole');                
                    Route::post('projects/{project_id}', 'Admin\UserController@attachProject');

                    Route::delete('roles/{role_id}', 'Admin\UserController@detachRole');                
                    Route::delete('projects/{project_id}', 'Admin\UserController@detachProject');
                });
            });
            /* End UserController route section */
            
            /*===================== ProjectController route section =====================*/
            Route::group(['prefix' => 'projects'], function(){
                Route::get('paginate', 'Admin\ProjectController@paginate');

                Route::get('{id}/orders', 'Admin\ProjectController@allOrders');

                Route::get('{id}/orders/paginate', 'Admin\ProjectController@paginatedOrders');

                Route::get('{id}/users', 'Admin\ProjectController@allUsers');

                Route::get('{id}/users/paginate', 'Admin\ProjectController@paginatedUsers');

                Route::group(['prefix' => '{id}'], function(){ 
                                                   
                    Route::post('users/{user_id}', 'Admin\ProjectController@attachUser');
                                
                    Route::delete('users/{user_id}', 'Admin\ProjectController@detachUser');
                });

            });   

            Route::apiResource('projects', 'Admin\ProjectController', [
                'parameters' => [
                    'projects' => 'id'
                ]
            ]);
            /* End ProjectController route section */
            
            /*===================== CategoryController route section =====================*/
            Route::group(['prefix' => 'categories'], function(){
                Route::get('paginate', 'Admin\CategoryController@paginate');

                Route::get('{id}/orders', 'Admin\CategoryController@allOrders');

                Route::get('{id}/orders/paginate', 'Admin\CategoryController@paginatedOrders');

            });   

            Route::apiResource('categories', 'Admin\CategoryController', [
                'parameters' => [
                    'categories' => 'id'
                ]
            ]);
            /* End CategoryController route section */
    
            /*===================== QuestionController route section =====================*/
            Route::group(['prefix' => 'questions'], function(){
                Route::get('paginate', 'Admin\QuestionController@paginate');

                Route::get('{id}/reviews', 'Admin\QuestionController@allReviews');

                Route::get('{id}/reviews/paginate', 'Admin\QuestionController@paginatedReviews');



            });   

            Route::apiResource('questions', 'Admin\QuestionController', [
                'parameters' => [
                    'questions' => 'id'
                ]
            ]);
            /* End QuestionController route section */
            
            /*===================== OrderController route section =====================*/
            Route::group(['prefix' => 'orders'], function(){
                Route::get('paginate', 'Admin\OrderController@paginate');

                Route::post('search', 'Admin\OrderController@search');
                
                Route::post('{id}/pdf', 'Admin\OrderController@pdf');
                
                Route::get('{id}/reviews', 'Admin\OrderController@allReviews');

                Route::get('{id}/reviews/paginate', 'Admin\OrderController@paginatedReviews');

                Route::get('{id}/loadings', 'Admin\OrderController@allLoadings');

                Route::get('{id}/loadings/paginate', 'Admin\OrderController@paginatedLoadings');



            });   

            Route::apiResource('orders', 'Admin\OrderController', [
                'parameters' => [
                    'orders' => 'id'
                ]
            ]);
            /* End OrderController route section */
            
            /*===================== ReviewController route section =====================*/
                Route::group(['prefix' => 'reviews'], function(){
                    Route::get('paginate', 'Admin\ReviewController@paginate');

                    Route::post('search', 'Admin\ReviewController@search');
                    
                    Route::post('pdf', 'Admin\ReviewController@pdfAll');
                    
                    Route::post('{id}/pdf', 'Admin\ReviewController@pdf');
                    
                    Route::get('{id}/questions', 'Admin\ReviewController@allQuestions');

                    Route::get('{id}/questions/paginate', 'Admin\ReviewController@paginatedQuestions');

                    Route::get('{id}/images', 'Admin\ReviewController@allImages');

                    Route::get('{id}/images/paginate', 'Admin\ReviewController@paginatedImages');

                    Route::post('{id}/questions/{question_id}', 'Admin\ReviewController@attachQuestion');

                    Route::delete('{id}/questions/{question_id}', 'Admin\ReviewController@detachQuestion');

                });   

                Route::apiResource('reviews', 'Admin\ReviewController', [
                    'parameters' => [
                        'reviews' => 'id'
                    ]
                ]);
                /* End ReviewController route section */
    
        });
    });
    
    /*===================== CategoryController route section =====================*/
//    Route::group(['prefix' => 'categories'], function(){
//        Route::get('paginate', 'CategoryController@paginate');
//        
//        Route::get('{id}/orders', 'CategoryController@allOrders');
//
//        Route::get('{id}/orders/paginate', 'CategoryController@paginatedOrders');
//
//    });   

//    Route::resource('categories', 'CategoryController', [
//        'parameters' => [
//            'categories' => 'id'
//        ],
//        'only' => [
//            'index', 'show'
//        ]
//    ]);
    /* End CategoryController route section */
    
    /*===================== ImageController route section =====================*/
//    Route::group(['prefix' => 'images'], function(){
//        Route::get('paginate', 'ImageController@paginate');
//
//    });   

    Route::resource('images', 'ImageController', [
        'parameters' => [
            'images' => 'id'
        ],
        'only' => [
            'store', 'destroy'
        ]
    ]);
    
    /* End ImageController route section */
    
    /*===================== LoadingController route section =====================*/
//    Route::group(['prefix' => 'loadings'], function(){
//        Route::get('paginate', 'LoadingController@paginate');
//        
//        Route::get('{id}/images', 'LoadingController@allImages');
//
//        Route::get('{id}/images/paginate', 'LoadingController@paginatedImages');
//
//
//
//    });   
//
//    Route::apiResource('loadings', 'LoadingController', [
//        'parameters' => [
//            'loadings' => 'id'
//        ]
//    ]);
    /* End LoadingController route section */
    
    /*===================== OrderController route section =====================*/
    Route::group(['prefix' => 'orders'], function(){
        Route::get('paginate', 'OrderController@paginate');
        
        Route::get('{id}/reviews', 'OrderController@allReviews');

        Route::get('{id}/reviews/paginate', 'OrderController@paginatedReviews');
        
        //Route::get('{id}/loadings', 'OrderController@allLoadings');

       // Route::get('{id}/loadings/paginate', 'OrderController@paginatedLoadings');

    });   

    Route::apiResource('orders', 'OrderController', [
        'parameters' => [
            'orders' => 'id'
        ],
        'only' => [
            'index', 'show'
        ]
    ]);
    /* End OrderController route section */
    
    /*===================== ProjectController route section =====================*/
    Route::group(['prefix' => 'projects'], function(){
        Route::get('paginate', 'ProjectController@paginate');
        
        Route::get('{id}/orders', 'ProjectController@allOrders');

        Route::get('{id}/orders/paginate', 'ProjectController@paginatedOrders');
        
        //Route::get('{id}/users', 'ProjectController@allUsers');

        //Route::get('{id}/users/paginate', 'ProjectController@paginatedUsers');



    });   

    Route::resource('projects', 'ProjectController', [
        'parameters' => [
            'projects' => 'id'
        ],
        'only' => [
            'show'
        ]
    ]);
    /* End ProjectController route section */
    
    /*===================== QuestionController route section =====================*/
    Route::group(['prefix' => 'questions'], function(){
        Route::get('paginate', 'QuestionController@paginate');
        
        //Route::get('{id}/reviews', 'QuestionController@allReviews');

        //Route::get('{id}/reviews/paginate', 'QuestionController@paginatedReviews');



    });   

    Route::resource('questions', 'QuestionController', [
        'parameters' => [
            'questions' => 'id'
        ],
        'only' => [
            'index', 'show'
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
//    Route::group(['prefix' => 'trucks'], function(){
//        Route::get('paginate', 'TruckController@paginate');
//
//
//
//    });   
//
//    Route::apiResource('trucks', 'TruckController', [
//        'parameters' => [
//            'trucks' => 'id'
//        ]
//    ]);
    /* End TruckController route section */
    
    /*===================== UserController route section =====================*/
    Route::group(['prefix' => 'users'], function(){
        Route::get("/me", 'UserController@me');
        //Route::put("/", 'UserController@update');
        
        Route::get('roles', 'UserController@allRoles');

        Route::get('roles/paginate', 'UserController@paginatedRoles');
        
        //Route::get('social-networks', 'UserController@allSocialNetworks');

        //Route::get('social-networks/paginate', 'UserController@paginatedSocialNetworks');
        
        Route::get('projects', 'UserController@allProjects');

        Route::get('projects/paginate', 'UserController@paginatedProjects');
        
        Route::get('reviews', 'UserController@allReviews');

        Route::get('reviews/paginate', 'UserController@paginatedReviews');
        
        //Route::get('loadings', 'UserController@allLoadings');

        //Route::get('loadings/paginate', 'UserController@paginatedLoadings');

        //Route::post('roles/{role_id}', 'UserController@attachRole');
        //Route::post('social-networks/{social_network_id}', 'UserController@attachSocialNetwork');
        //Route::post('projects/{project_id}', 'UserController@attachProject');

        //Route::delete('roles/{role_id}', 'UserController@detachRole');
        //Route::delete('social-networks/{social_network_id}', 'UserController@detachSocialNetwork');
        //Route::delete('projects/{project_id}', 'UserController@detachProject');

    });
    /* End UserController route section */


});

