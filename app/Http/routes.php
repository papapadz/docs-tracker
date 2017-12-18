<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('indx');
});
Route::get('home', function () {
    return view('indx');
});


Route::group(['middlewareGroups' => ['web']], function(){
    Route::auth();

    Route::get('menu', 'AdminController@redirectview')->middleware('isAdmin');
    Route::get('/admin/home', 'AdminController@viewmenu')->middleware('isAdmin');
    Route::post('/admin/home', 'AdminController@searchtask')->middleware('isAdmin');

    Route::get('/admin/add-task', 'AdminController@viewaddtask')->middleware('isAdmin');
    Route::post('/admin/add-task', 'AdminController@addtask')->middleware('isAdmin');
    Route::get('/admin/edit-task/{task_id}', 'AdminController@viewedittask')->middleware('isAdmin');
    Route::post('/admin/edit-task/{task_id}', 'AdminController@edittask')->middleware('isAdmin');
    Route::get('/admin/set-taskstat/{task_id}', 'AdminController@taskundone')->middleware('isAdmin');

    Route::get('/admin/delete-task/{task_id}', 'AdminController@deletetask')->middleware('isAdmin');

    Route::get('/admin/inventory-requests', 'AdminController@viewinventoryreq')->middleware('isAdmin');
    Route::post('/admin/inventory-requests', 'AdminController@searchinventoryreq')->middleware('isAdmin');
    Route::get('/admin/approve-request/{inventoryreq_id}', 'AdminController@approveinventoryreq')->middleware('isAdmin');
    Route::get('/admin/disapprove-request/{inventoryreq_id}', 'AdminController@disapproveinventoryreq')->middleware('isAdmin');

    Route::get('/admin/staff-logs', 'AdminController@viewstafflogs')->middleware('isAdmin');
    Route::post('/admin/staff-logs', 'AdminController@searchstafflogs')->middleware('isAdmin');

    Route::get('/admin/dogs-onboard', 'AdminController@dogsonboard')->middleware('isAdmin');
    Route::get('/admin/staff-onduty', 'AdminController@staffonduty')->middleware('isAdmin');

    Route::get('/admin/petinfo/{pet_id}','PetInfoController@petprofile')->middleware('isAdmin');
    Route::get('/admin/petinfo/breed/{breed_id}','PetInfoController@selectbreed')->middleware('isAdmin');
    Route::get('/admin/petinfo/age','PetInfoController@sortage')->middleware('isAdmin');
    Route::get('/admin/petinfo', 'PetInfoController@petinfo')->middleware('isAdmin');
    Route::post('/admin/petinfo', 'PetInfoController@searchpet')->middleware('isAdmin');
    Route::get('/admin/add-pet', 'PetInfoController@viewaddpet')->middleware('isAdmin');
    Route::post('/admin/add-pet', 'PetInfoController@addpet')->middleware('isAdmin');
    Route::get('/admin/edit-petinfo/{pet_id}', 'PetInfoController@vieweditpetinfo')->middleware('isAdmin');
    Route::post('/admin/edit-petinfo/{pet_id}', 'PetInfoController@editpetinfo')->middleware('isAdmin');

    Route::get('/admin/set-dogboard/{pet_id}', 'PetInfoController@viewsetdogboard')->middleware('isAdmin');
    Route::post('/admin/set-dogboard/{pet_id}', 'PetInfoController@setdogboard')->middleware('isAdmin');

    Route::get('/admin/userinfo', 'UserInfoController@userinfo')->middleware('isAdmin');
    Route::get('/admin/userinfo/{user_id}', 'UserInfoController@userprofile')->middleware('isAdmin');
    Route::post('/admin/userinfo', 'UserInfoController@searchuser')->middleware('isAdmin');
    Route::get('/admin/add-petparent', 'UserInfoController@viewaddparent')->middleware('isAdmin');
    Route::post('/admin/add-petparent', 'UserInfoController@addparent')->middleware('isAdmin');

    Route::get('/admin/staffinfo', 'StaffInfoController@staffinfo')->middleware('isAdmin');
    Route::get('/admin/staffinfo/{staff_id}', 'StaffInfoController@staffprofile')->middleware('isAdmin');
    Route::post('/admin/staffinfo', 'StaffInfoController@searchstaff')->middleware('isAdmin');
    Route::get('/admin/add-staff', 'StaffInfoController@viewaddstaff')->middleware('isAdmin');
    Route::post('/admin/add-staff', 'StaffInfoController@addstaff')->middleware('isAdmin');

    Route::get('/user/user-home', 'StaffInfoController@staffhome')->middleware('isAdmin');
    Route::post('/user/user-home', 'StaffInfoController@addlog')->middleware('isAdmin');

    Route::get('/user/task-done/{task_id}', 'StaffInfoController@taskdone')->middleware('isAdmin');
    Route::get('/user/my-requests', 'StaffInfoController@viewmyinvreq')->middleware('isAdmin');
    Route::post('/user/my-requests', 'StaffInfoController@addinvreq')->middleware('isAdmin');
    Route::get('/user/cancel-request/{inventoryreq_id}', 'StaffInfoController@cancelreq')->middleware('isAdmin');
    Route::post('/user/search-request', 'StaffInfoController@searchreq')->middleware('isAdmin');

    Route::get('/user/my-logs', 'StaffInfoController@viewmylogs')->middleware('isAdmin');
    Route::post('/user/my-logs', 'StaffInfoController@searchlog')->middleware('isAdmin');

    Route::get('/user/pets-onboard', 'StaffInfoController@viewpetsonboard')->middleware('isAdmin');
    Route::get('/user/pet-profile/{pet_id}', 'PetinfoController@viewpetprofile2')->middleware('isAdmin');

});
