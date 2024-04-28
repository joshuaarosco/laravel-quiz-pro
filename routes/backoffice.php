<?php


/**
 *
 * ------------------------------------
 * Backoffice Routes
 * ------------------------------------
 *
 */
Route::group(['middleware' => "backoffice.guest", 'as' => "auth." ], function(){
    Route::get('login',['as' => "login", 'uses' => "LoginController@login"]);
    Route::post('login',['uses' => "LoginController@authenticate"]);
    Route::get('register-{user_type}',['as' => "register",'uses' => "RegisterController@index"]);
    Route::post('register-{user_type}',['uses' => "RegisterController@register"]);
});

Route::group(['middleware' => ["backoffice.auth"/*, "backoffice.superUserOnly"*/]], function(){
    Route::get('logout',['as' => "logout",'uses' => "LoginController@logout"]);
    Route::get('/',['as' => "index",'uses' => "DashboardController@index"]);

    
    Route::group(['as' => "account.", 'prefix' => "account"], function(){
        Route::get('/',['as' => "index",'uses' => "AccountController@index"]);
        Route::post('/',['uses' => "AccountController@update"]);
        Route::post('update-password',['as' => "update_password",'uses' => "AccountController@updatePassword"]);
        Route::get('send-verification',['as' => "send_verification",'uses' => "AccountController@sendVerification"]);
        Route::get('verify-account/{username}',['as' => "verify_account",'uses' => "AccountController@verifyAccount"]);
    });

    Route::group(['as' => "instructor.", 'prefix' => "instructor", 'middleware' => ["backoffice.superUserOnly"]], function(){
        Route::get('/',['as' => "index",'uses' => "ProfessorController@index"]);
        Route::post('/',['as' => "create",'uses' => "ProfessorController@create"]);
        Route::post('edit',['as' => "edit",'uses' => "ProfessorController@edit"]);
        Route::post('update',['as' => "update",'uses' => "ProfessorController@update"]);
        Route::any('delete/{id}',['as' => "delete",'uses' => "ProfessorController@delete"]);
    });

    Route::group(['as' => "student.", 'prefix' => "student"], function(){
        Route::get('/',['as' => "index",'uses' => "StudentController@index"]);
        Route::post('/',['as' => "create",'uses' => "StudentController@create"]);
        Route::get('view/{id}',['as' => "view",'uses' => "StudentController@view"]);
        Route::post('edit',['as' => "edit",'uses' => "StudentController@edit"]);
        Route::post('update',['as' => "update",'uses' => "StudentController@update"]);
        Route::any('delete/{id}',['as' => "delete",'uses' => "StudentController@delete"]);
    });

    Route::group(['as' => "quiz.", 'prefix' => "quiz"], function(){
        //Admin and Prof Routes
        Route::group(['middleware' => ["backoffice.superUserOnly"]], function(){
            Route::get('/',['as' => "index", 'uses' => "QuizController@index"]);
            Route::get('create',['as' => "create", 'uses' => "QuizController@create"]);
            Route::post('patch',['as' => "patch", 'uses' => "QuizController@patch"]);
            Route::get('view/{id}',['as' => "view", 'uses' => "QuizController@view"]);
            Route::post('view/{id}',['uses' => "QuizController@saveQuiz"]);
            Route::post('create',['uses' => "QuizController@store"]);
            Route::any('generate/{type}',['as' => "generate", 'uses' => "QuizController@genQuestions"]);
            Route::any('delete/{id}',['as' => "delete", 'uses' => "QuizController@delete"]);
            Route::get('assign/{id}',['as' => "assign", 'uses' => "QuizController@assign"]);
            Route::post('assign/{id}',['uses' => "QuizController@assignStudent"]);
            Route::get('results/{id}',['as' => "results", 'uses' => "QuizController@results"]);
        });

        //Student Routes
        Route::any('pending',['as' => "pending", 'uses' => "AnswerController@index"]);
        Route::get('answer/{id}',['as' => "answer", 'uses' => "AnswerController@answer"]);
        Route::post('answer/{id}',['uses' => "AnswerController@submitAnswer"]);
        Route::any('update-clock/{id}',['as' => "update_clock", 'uses' => "AnswerController@updateClock"]);

        Route::any('result',['as' => "result", 'uses' => "QuizController@result"]);
    });
});
