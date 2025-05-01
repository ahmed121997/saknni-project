<?php

use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\CommentPropertyController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\PropertyController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;

require __DIR__.'/admin.php';


Auth::routes(['verify'=>true]);

// welcome
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('lang/{lang}', [WelcomeController::class, 'lang'])->name('lang.switch');
Route::get('/special-properties',[WelcomeController::class, 'allSpecial'])->name('all.special.properties');
Route::get('/s',[SearchController::class, 'mainSearch'])->name('main.search');
Route::get('/about',[AboutController::class, 'index'])->name('about');



Route::group(['prefix'=>'property'],function(){
    Route::get('/show/{id}',[PropertyController::class, 'show'])->name('show.property');
    Route::get('/add',[PropertyController::class, 'create'])->name('add.property');
    Route::any('get_cities',[PropertyController::class, 'getCities'])->name('get.cities');
    Route::any('store',[PropertyController::class, 'store'])->name('store.property');
    Route::get('edit/{id}',[PropertyController::class, 'edit'])->name('edit.property');
    Route::any('update',[PropertyController::class, 'update'])->name('update.property');
    Route::post('property-image/{id}/delete',[PropertyController::class, 'deleteImage'])->name('property.delete.image');

    Route::any('comments',[CommentPropertyController::class, 'store'])->name('comments.store');
    Route::delete('comments/{id}/delete',[CommentPropertyController::class, 'destroy'])->name('comments.destroy');

    Route::get('/',[PropertyController::class, 'index'])->name('show.all.properties');
    Route::get('/delete/{id}',[PropertyController::class, 'delete'])->name('delete.property');
    Route::post('favorite',[PropertyController::class, 'favorite'])->name('add.favorite');

    Route::get('search',[SearchController::class, 'index'])->name('index.search');
    Route::any('process',[SearchController::class, 'process'])->name('process.search');

    Route::get('activation/{id}',[PaymentController::class, 'activation'])->name('property.activation');
    Route::get('get-check-id',[PaymentController::class, 'getCheckId'])->name('get.check.id');

});

Route::group(['prefix'=>'user','middleware'=>'auth'],function(){
    Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware('verified');
    Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/change_password', [UserController::class, 'change_password'])->name('user.change_password');
    Route::any('/store_change_password/{id}', [UserController::class, 'store_change_password'])->name('user.store_change_password');
    Route::get('/favorite', [UserController::class, 'favorite'])->name('user.favorite');
    Route::any('/update/{id}', [UserController::class, 'update'])->name('user.update');
});
