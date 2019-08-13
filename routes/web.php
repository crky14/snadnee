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

/*
 * Get routes
 */
Route::get('/', 'TransactionController@showAll')->name('transactions');
Route::get('/categoies', 'CategoriesController@showAll')->name('categories');
Route::get('/discard_word/{id}', 'CategoriesController@discardWordById')->name('discard');
/*
 * Post routes
 */
Route::post('/select_category', 'CategoriesController@useExistingCategory')->name('select_category');
Route::post('/create_category', 'CategoriesController@createNewCategory')->name('create_category');
