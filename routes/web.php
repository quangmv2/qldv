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
Auth::routes([
    'register' => false,
    'reset' => false, 
    'verify' => false, 
  ]);

Route::get('/point/{id}', function ($id) {
    $rd = rand(0, 4);
    $result = [
        "code" => 200,
        "id_student" => $id,
        "point" => $rd,
    ];
    return json_encode($result);
});

Route::get('logout', "LoginController@logout")->name('logout');

Route::get('auth/{provider}', "Auth\LoginController@redirectToProvider")->name('loginGG');

Route::get('auth/{provider}/callback', "Auth\LoginController@handleProviderCallback");

Route::get('excel', "ExcelController@export")->name('export');

Route::group(['middleware' => 'studentMiddleware'], function () {

    Route::get('/', function () {
        return view('client.index');
    });

    Route::get('sv', function () {
        return view('client.login');
    });

    Route::post('profile',"ClientController\ProfileController@index")->name('edit_profile');
    Route::get('profile',"ClientController\ProfileController@getProfile")->name('get_profile');

    Route::get('hoat-dong-moi', "ClientController\ActionController@getNewAction")->name('newActionList');

    Route::get('hoat-dong-moi/{id_action}', "ClientController\ActionController@getNewActionDetail")->name('newActionDetail');

    Route::post('hoat-dong-moi/{id_action}', "ClientController\ActionController@postRegisterAction");

    Route::get('hoat-dong', "ClientController\ActionController@getMyAction")->name('myAction');


    Route::group(['prefix' => 'diem-ren-luyen-cua-toi'], function () {

        Route::get('/', "ClientController\MyPointController@getList")->name('myPoint');

        Route::get('/{id_dot}', "ClientController\MyPointController@getDanhGia")->name('getMyDot');

        Route::post('/{id_dot}', "ClientController\MyPointController@postDanhGia");

    });

    Route::group(['prefix' => 'diem-ren-luyen'], function () {

        Route::get('them-moi', "ClientController\DotXetDiemController@getAdd")->name('addPoint');

        Route::post('them-moi', "ClientController\DotXetDiemController@postAdd");

        Route::group(['prefix' => 'danh-sach-dot'], function () {

            Route::group(['middleware' => ['positionMiddleware']], function () {
                Route::get('/', "ClientController\DotXetDiemController@danhSachDot")->name('danh_sach_dot');

                Route::get('/delete/{id_dot}', "ClientController\DotXetDiemController@delete")->name('get_xoa_dot');

                Route::get('note/{id_dot}/{id_student}', "ClientController\DotXetDiemController@getNote")->name('getDotNote');

                Route::get('/{id_dot}', "ClientController\DotXetDiemController@getDot")->name('getDot');

                Route::get('/{id_dot}_{id_detail}/{name}_{id_student}', "ClientController\PointController@getDanhGia")->name('getDanhGia');

                Route::post('/{id_dot}_{id_detail}/{name}_{id_student}', "ClientController\PointController@postDanhGia");

                Route::get('download/{id_dot}', "ClientController\DotXetDiemController@downloadDotPDF")->name('downDot');

            });
            Route::get('/download/pdf/{id_student}_{id_dot}', "ClientController\PointController@downloadPointPDF")->name('downloadPointPDF');
        });



    });

    Route::group(['prefix' => 'diem-danh', 'middleware' => 'positionMiddleware'], function () {

        Route::get('/', "ClientController\AttendanceController@getList")->name('attendanceList');

        Route::get('{id}', "ClientController\AttendanceController@getAttendance")->name('attendance');

        Route::post('note/{id_action}/{id_student}', "ClientController\AttendanceController@postAttendanceNote")->name('note_attendance');

        Route::get('{id_action}/point/{id_student}', "ClientController\AttendanceController@getPoint");

        Route::get('{id_action}/{id_student}', "ClientController\AttendanceController@postApiAttendance");

    });

    Route::group(['prefix' => 'hoat-dong', 'middleware' => 'positionMiddleware'], function () {

        Route::get('danh-sach', "ClientController\ActionController@getList")->name("actionList");

        Route::get('them-moi', "ClientController\ActionController@getAdd")->name('addAction');

        Route::post('them-moi', "ClientController\ActionController@postAdd");

        Route::get('xoa/{id}', "ClientController\ActionController@getDelete")->name('deleteAction');

    });

});
// , 'middleware' => 'adminMiddleware'
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

        Route::get('add-excel', "AdminController\StudentController@getAddExcel")->name('add-excel');
        
        Route::post('add-excel', "AdminController\StudentController@postAddExcel");

        Route::get('ajaxList', "AdminController\StudentController@getListAjax")->name('ajaxStudentList');

    });

});


Route::get('home', function () {
    return redirect()->route('newActionList');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
