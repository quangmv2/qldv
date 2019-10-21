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

Route::get('/', function () {
    return view('client.index');
});

Route::get('login', function() {
    return view('login');
})->name('getLogin');

Route::get('sv', function () {
    return view('client.login');
});

Route::get('hoat-dong-moi', function () {
    return view('client.action.newActionList');
})->name('newAction');

Route::group(['prefix' => 'hoat-dong'], function () {
    
    Route::get('/', function () {
        return view('client.action.myActionList');
    })->name('myAction');

    Route::get('danh-sach', function ($id) {
        
    });

    Route::get('them-moi', "ClientController\ActionController@getAdd")->name('addAction');

    Route::post('them-moi', "ClientController\ActionController@postAdd");


});

Route::get('auth/{provider}', "Auth\LoginController@redirectToProvider")->name('loginGG');

Route::get('auth/{provider}/callback', "Auth\LoginController@handleProviderCallback");

Route::group(['prefix' => 'admin'], function () {
    
    Route::get('/', function () {
        return view('admin.index');
    })->name('adminIndex');

    Route::group(['prefix' => 'class'], function () {
        
        Route::get('/', "AdminController\ClassController@getList")->name('adminListClass');

        Route::get('add', "AdminController\ClassController@getAdd")->name('adminAddClass');

        Route::post('add', "AdminController\ClassController@postAdd");

        Route::get('edit/{class}', "AdminController\ClassController@getEdit")->name('adminEditClass');

        Route::post('edit/{class}', "AdminController\ClassController@postEdit");

    });

    Route::group(['prefix' => 'student'], function () {
        
        Route::get('/', "AdminController\StudentController@getList")->name('adminListStudent');

        Route::get('add', "AdminController\StudentController@getAdd")->name('adminAddStudent');

        Route::post('add', "AdminController\StudentController@postAdd");

        Route::get('ajaxList', "AdminController\StudentController@getListAjax")->name('ajaxStudentList');

    });
    
});