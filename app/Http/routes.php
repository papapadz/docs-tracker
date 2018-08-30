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

Route::group(['middlewareGroups' => ['web']], function(){
    Route::auth();

    /* MainController */
    Route::get('home', [
        'uses' => 'MainController@viewmenu',
        'as' => 'view.home'
    ]);
    Route::post('home', 'MainController@addnewdoc')->middleware('isAdmin');
    Route::get('logout', 'MainController@logout')->middleware('isAdmin');

    Route::get('new-doc/{type_id}', 'MainController@viewnewdoc')->middleware('isAdmin');
    Route::get('document/{doc_id}', 'MainController@viewdocinfo')->middleware('isAdmin');
    Route::get('document/pdf/{doc_id}', 'MainController@viewpdf')->middleware('isAdmin');
    Route::get('set-remarks', 'MainController@setremarks')->middleware('isAdmin');
    Route::get('endorsements', 'MainController@viewendorsed')->middleware('isAdmin');
    Route::get('document/done/{doc_id}', 'MainController@markdonedoc')->middleware('isAdmin');
    Route::get('document/undone/{doc_id}', 'MainController@markundonedoc')->middleware('isAdmin');
    Route::get('document/archive/{doc_id}', 'MainController@archivedoc')->middleware('isAdmin');
    Route::get('document/restore/{doc_id}', 'MainController@restoredoc')->middleware('isAdmin');

    Route::get('updatepr', 'MainController@updatepr')->middleware('isAdmin');
    Route::get('updatecac', 'MainController@updatecac')->middleware('isAdmin');
    Route::get('updatebill', 'MainController@updatebill')->middleware('isAdmin');
    Route::post('updateall', 'MainController@updateall')->middleware('isAdmin');

    Route::get('employees', 'MainController@viewstaff')->middleware('isAdmin');
    Route::get('employees/new', 'MainController@viewaddstaff')->middleware('isAdmin');
    Route::get('employees/new/add', 'MainController@addstaff')->middleware('isAdmin');
    Route::get('employees/view/{user_id}', 'MainController@viewstaffdetails')->middleware('isAdmin');
    Route::get('employees/update', 'MainController@updateemployee')->middleware('isAdmin');

    Route::get('payments', 'MainController@viewpayments')->middleware('isAdmin');

    Route::get('settings/document-types', 'MainController@viewdoctypes')->middleware('isAdmin');
    Route::get('settings/document-types/update', 'MainController@updatedoctype')->middleware('isAdmin');
    Route::get('settings/document-types/add', 'MainController@adddoctype')->middleware('isAdmin');
    Route::get('settings/document-types/delete', 'MainController@deldoctype')->middleware('isAdmin');

    Route::get('settings/client-types', 'MainController@viewclienttypes')->middleware('isAdmin');
    Route::get('settings/client-types/update', 'MainController@updateclienttype')->middleware('isAdmin');
    Route::get('settings/client-types/add', 'MainController@addclienttype')->middleware('isAdmin');
    Route::get('settings/client-types/delete', 'MainController@delclienttype')->middleware('isAdmin');

    Route::get('settings/qualifications', 'MainController@viewcourses')->middleware('isAdmin');
    Route::get('settings/courses/update', 'MainController@updatecourse')->middleware('isAdmin');
    Route::get('settings/courses/add', 'MainController@addcourse')->middleware('isAdmin');
    Route::get('settings/courses/delete', 'MainController@delcourse')->middleware('isAdmin');

    Route::get('settings/agency-types', 'MainController@viewagencytypes')->middleware('isAdmin');
    Route::get('settings/agency-types/update', 'MainController@updateagencytype')->middleware('isAdmin');
    Route::get('settings/agency-types/add', 'MainController@addagencytype')->middleware('isAdmin');
    Route::get('settings/agency-types/delete','MainController@delagencytype')->middleware('isAdmin');

    Route::get('settings/serial-numbers', 'MainController@viewserialnum')->middleware('isAdmin');
    Route::get('settings/serial-numbers/add', 'MainController@addserialnum')->middleware('isAdmin');
    Route::get('settings/serial-numbers/update', 'MainController@updateserialnum')->middleware('isAdmin');
    Route::get('settings/serial-numbers/delete', 'MainController@delserialnum')->middleware('isAdmin');

    Route::get('misc/archives', 'MainController@viewarchive')->middleware('isAdmin');
    Route::get('misc/logs', 'MainController@viewlogs')->middleware('isAdmin');
    /* ClientsController */
    Route::get('agencies', [
        'uses' => 'ClientsController@vieworigin',
        'as' => 'agencies.list'
    ]);
    Route::get('agencies/new', 'ClientsController@viewneworigin');
    Route::get('agencies/new/add', 'ClientsController@addneworigin');
    Route::get('agencies/view/{origin_id}', 'ClientsController@vieworigindetails');
    Route::get('agencies/update', 'ClientsController@updateorigin')->middleware('isAdmin');
    //Route::get('agencies/delete/{id}', 'ClientsController@deleteorigin')->middleware('isAdmin');

    Route::get('assessors', [
        'uses' => 'ClientsController@viewassessors',
        'as' => 'assessors.list'
    ]);
    Route::get('assessors/new', 'ClientsController@viewnewassessor')->middleware('isAdmin');
    Route::post('assessors/new/add', 'ClientsController@addnewassessor')->middleware('isAdmin');
    Route::get('assessors/view/{id}', 'ClientsController@viewassessordetails')->middleware('isAdmin');
    Route::post('assessors/update', 'ClientsController@updateassessor')->middleware('isAdmin');
    Route::get('assessors/delete/{aid}', 'ClientsController@deleteassessor')->middleware('isAdmin');
    Route::get('certificate/pdf/{id}', 'ClientsController@viewpdf')->middleware('isAdmin');

    /* GettersController */
    Route::get('settings/getdoctypeinfo', 'GettersController@getdoctypeinfo')->middleware('isAdmin');
    Route::get('settings/getclienttypeinfo', 'GettersController@getclienttypeinfo')->middleware('isAdmin');
    Route::get('settings/getcourseinfo', 'GettersController@getcourseinfo')->middleware('isAdmin');
    Route::get('settings/getagencytypeinfo', 'GettersController@getagencytypeinfo')->middleware('isAdmin');
    Route::get('settings/getserialnuminfo', 'GettersController@getserialnuminfo')->middleware('isAdmin');
    Route::get('getcheckinfo', 'GettersController@getcheckdetails')->middleware('isAdmin');
    Route::get('checkduplicate', 'GettersController@checkduplicate')->middleware('isAdmin');

});
