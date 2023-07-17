<?php

use Illuminate\Support\Facades\Route;

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
// The root uri of application
Route::get('/', 'NoteItemController@index')->name('showNotesPage');
Route::get('/notes', 'NoteItemController@notes')->name('loadNotes');
Route::post('/notes', 'NoteItemController@store')->name('storeNotes');
Route::put('/notes/{noteItem}', 'NoteItemController@update')->name('updateNote');
Route::delete('/notes/{noteItem}', 'NoteItemController@destroy')->name('deleteNote');
