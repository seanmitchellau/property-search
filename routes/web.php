<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPropertiesController;

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

Route::get('/', [Controller::class, 'index'])->name('index');

/**
 * Administration routes
 */
Route::middleware(['auth:sanctum'])->get('/dashboard', 'App\Http\Controllers\AdminController@index')->name('dashboard');

Route::middleware(['auth:sanctum'])->put('/properties/togglePublished/{property}', 'App\Http\Controllers\AdminPropertiesController@togglePublished')->name('properties.togglePublished');
Route::middleware(['auth:sanctum'])->resource('properties', AdminPropertiesController::class);