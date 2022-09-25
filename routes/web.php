<?php

use App\Http\Controllers\MagazineController;
use App\Http\Controllers\ModerationCommentController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\LetterHeadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
	return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('maintenance', function () {
	return view('maintenance');
})->name('maintenance');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
	Route::get('map', function () {
		return view('pages.maps');
	})->name('map');
	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');
	Route::get('table-list', function () {
		return view('pages.tables');
	})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

//magazine
Route::get('magazine', [MagazineController::class, 'index'])->name('magazine');
Route::get('magazine/own-magazine', [MagazineController::class, 'ownMagazine']);
Route::get('magazine/create', [MagazineController::class, 'create']);
Route::post('magazine', [MagazineController::class, 'store']);
Route::get('magazine/{magazine}', [MagazineController::class, 'show']);
Route::get('magazine/{magazine}/edit', [MagazineController::class, 'edit']);
Route::put('magazine/{magazine}', [MagazineController::class, 'update']);
Route::patch('magazine/{magazine}/approve', [MagazineController::class, 'approve']);
Route::patch('magazine/{magazine}/cancel', [MagazineController::class, 'cancel']);
Route::delete('magazine/{magazine}', [MagazineController::class, 'softDelete']);
Route::get('magazine/browse/dashboard', [MagazineController::class, 'browse']);
Route::get('magazine/choose/type', function () {
	return view('pages.magazine.public.option');
})->name('magazine.choose_type');
Route::post('magazine/inline/editor', [MagazineController::class, 'storeEditor'])->name('magazine/inline/editor');
Route::patch('magazine/inline/editor/{magazine}', [MagazineController::class, 'updateEditor']);
Route::get('magazine/inline/editor', function () {
	return view('pages.magazine.public.editor');
})->name('magazine.editor');
//magazine & comment
Route::get('magazine/{magazine}/comment', [MagazineController::class, 'showMagazineComment'])->name('magazine.comment');

//moderation comment
Route::post('moderation-comment/{magazine}', [ModerationCommentController::class, 'store']);
Route::get('moderation-comment/{magazine}/{moderationComment}/edit', [ModerationCommentController::class, 'edit']);
Route::put('moderation-comment/{moderationComment}', [ModerationCommentController::class, 'update']);

//letter
Route::get('letter', [LetterController::class, 'index'])->name('letter');
Route::get('letter/create', [LetterController::class, 'create']);
Route::post('letter', [LetterController::class, 'store']);
Route::get('letter/{letter}', [LetterController::class, 'show']);
Route::get('letter/{letter}/edit', [LetterController::class, 'edit']);
Route::patch('letter/{letter}', [LetterController::class, 'update']);
Route::delete('letter/{letter}', [LetterController::class, 'softDelete']);
//letter for principal
Route::patch('letter/{letter}/principal-update', [LetterController::class, 'principalUpdate'])->middleware('principal');
//create response letter for teacher or TU
Route::get('letter-reviewed', [LetterController::class, 'letterReviewed'])->name('letter-reviewed');
Route::get('reply-letter/{letter}/create', [LetterController::class, 'createReplyLetter']);
Route::post('reply-letter', [LetterController::class, 'storeReplyLetter']);

//letter head
Route::get('letter-head', [LetterHeadController::class, 'index'])->name('letter-head');
Route::get('letter-head/create', [LetterHeadController::class, 'create']);
Route::post('letter-head', [LetterHeadController::class, 'store']);
Route::get('letter-head/{letterHead}', [LetterHeadController::class, 'show']);
Route::get('letter-head/{letterHead}/edit', [LetterHeadController::class, 'edit']);
Route::patch('letter-head/{letterHead}', [LetterHeadController::class, 'update']);
Route::delete('letter-head/{letterHead}', [LetterHeadController::class, 'softDelete']);
