<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\ListViewController;
use App\Http\Controllers\Admin\PropertyAdminController;
use App\Http\Controllers\Admin\TypeFinishController;
use App\Http\Controllers\Admin\TypePropertyController;
use App\Http\Controllers\Admin\UserAdminController;
use Illuminate\Support\Facades\Route;

/**
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::group(['prefix'=>'admin', 'as' => 'admin.', 'middleware' => 'guest:admin'],function(){
    Route::get('/login', [AdminController::class, 'adminLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'adminCheck'])->name('check');
});

Route::group(['prefix'=>'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'],function(){
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [AdminController::class, 'profile_edit'])->name('profile.edit');
    Route::post('/profile/update/{id}', [AdminController::class, 'profile_update'])->name('profile.update');

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');


    Route::get('/user', [UserAdminController::class, 'user'])->name('user');
    Route::post('/user/datatable', [UserAdminController::class, 'userDatatable'])->name('users.datatable');
    Route::post('/verify_user', [UserAdminController::class, 'verify_user'])->name('verify.user');

    Route::get('/property', [PropertyAdminController::class, 'property'])->name('property');
    Route::post('/property/datatable', [PropertyAdminController::class, 'propertyDatatable'])->name('properties.datatable');
    Route::post('/verify_property', [PropertyAdminController::class, 'verify_property'])->name('verify.property');
    Route::post('/update_special_property', [PropertyAdminController::class, 'update_special_property'])->name('update.special.property');
    Route::get('/special-properties', [PropertyAdminController::class, 'allSpecial'])->name('all.special.properties');


    Route::resource('type-properties', TypePropertyController::class)->only(['index', 'store', 'edit', 'destroy']);
    Route::post('/type-properties/datatable', [TypePropertyController::class, 'typePropertyDatatable'])->name('type-properties.datatable');
    Route::resource('list-views', ListViewController::class)->only(['index', 'store', 'edit', 'destroy']);
    Route::post('/list-views/datatable', [ListViewController::class, 'listViewDatatable'])->name('list-views.datatable');
    Route::resource('type-finishes', TypeFinishController::class)->only(['index', 'store', 'edit', 'destroy']);
    Route::post('/type-finishes/datatable', [TypeFinishController::class, 'typeFinishDatatable'])->name('type-finishes.datatable');

    //filemanager routes
    Route::get('/filemanager',[ FileManagerController::class, 'index'])->name('filemanager.index');


});

Route::group([
    'prefix' => 'admin/media-filemanager',
    'middleware' => ['web', 'auth:admin'],
], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

