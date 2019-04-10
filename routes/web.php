<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('root');

Route::get('home/{name?}', [
    'uses' => 'HomeController@home',
    'as' => 'home'
]);

Route::get('code-sample', [
    'uses' => 'HomeController@codeSample',
    'as' => 'code-sample'
]);

// Route::get('home/{name?}', function ($name="VJ") {
//     'uses' => 'HomeController@codeSample',
//         'as' => 'contact-post'
//     return view('userhome', ['n' => $name]);
// })->name('home');

Route::group(['prefix' => 'contact'], function () {
    Route::get('contact-us', function () {
        return view('contact.contactus');
    })->name('contact-us');

    Route::post('contact-post', [
        'uses' => 'ContactController@query_submit',
        'as' => 'contact-post'
    ]);
});

Route::get('entry/list', [
    'uses' => 'EntryController@get_entries',
    'as'    => 'entry_list'
]);

Route::get('manage/entry/list', [
    'uses' => 'EntryController@get_manage_entries',
    'as'    => 'manage_entry_list'
]);

Route::get('manage/entry/delete/{ei}', [
    'uses' => 'EntryController@entry_delete',
    'as'    => 'entry_delete'
]);

Route::get('manage/tags', [
    'uses' => 'TagController@manage_tags',
    'as'    => 'manage_tag_list'
]);

Route::get('manage/authors/{ai?}', [
    'uses' => 'AuthorController@manage_authors',
    'as'    => 'manage_author_list'
]);

Route::get('entry/author/{s}',[
    'uses' => 'EntryController@get_author_entries',
    'as'    => 'entry_author'
]);

Route::get('entry/tag/{ti}',[
    'uses' => 'EntryController@get_tag_entries',
    'as'    => 'entry_tag'
]);

Route::get('entry/add/{ei?}', [
    'uses' => 'EntryController@view_add_entry',
    'as'    => 'entry_add'
]);

Route::post('/create', [
    'uses' => 'EntryController@entry_submit',
    'as'    => 'entry_create'
]);

Route::match(array('GET','POST'),'/admin/login/{a?}', [
    'uses' => 'UserController@admin_login',
    'as'    => 'admin_login'
]);

Route::get('/admin/logout', [
    'uses' => 'UserController@admin_logout',
    'as'    => 'admin_logout'
]);

Route::post('/manage/tags/create', [
    'uses' => 'TagController@add_new_tag',
    'as'    => 'manage_tag_add'
]);

Route::post('/manage/tags/get_tag', [
    'uses' => 'TagController@get_tag',
    'as'    => 'get_tag'
]);

Route::post('/manage/tags/update', [
    'uses' => 'TagController@update_tag',
    'as'    => 'manage_tag_update'
]);

Route::post('/manage/tags/delete', [
    'uses' => 'TagController@delete_tag',
    'as'    => 'manage_tag_delete'
]);

Route::post('/manage/authors/update', [
    'uses' => 'AuthorController@update_author',
    'as'    => 'manage_author_update'
]);

Route::post('/manage/authors/get_name', [
    'uses' => 'AuthorController@get_name',
    'as'    => 'manage_author_get_name'
]);

Route::post('/manage/authors/toggle', [
    'uses' => 'AuthorController@toggle_status',
    'as'    => 'manage_author_status'
]);
