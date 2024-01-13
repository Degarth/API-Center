<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ApodController;
use App\Http\Controllers\ISSController;
use App\Http\Controllers\JokeController;
use App\Http\Controllers\NeoWController;
use App\Http\Controllers\GeoCitiesController;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\WikiController;
use App\Http\Controllers\SQLController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\WorldBankController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\BioController;
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

Route::get('/', [PagesController::class, 'index']);
//APOD
Route::get('/apod', [ApodController::class, 'index']);
Route::post('/apod-by-date', [ApodController::class, 'byDate'])->name('submit.date');
//ISS
Route::get('/iss', [ISSController::class, 'index']);
//Joke
Route::get('/joke', [JokeController::class, 'index']);
Route::get('/new-joke', [JokeController::class, 'newJoke'])->name('new.joke');
//NeoW
Route::get('/neow/{page?}', [NeowController::class, 'index'])->name('neow');
Route::get('/neow-globe/{page?}/{id?}', [NeowController::class, 'globe'])->name('neow.globe');
//Old Internet
Route::get('/geocities', [GeoCitiesController::class, 'index']);
Route::post('/geocities/search', [GeoCitiesController::class, 'search'])->name('geocities.search');
//JWT
Route::get('/jwt', [JWTController::class, 'index']);
Route::post('/jwt-show', [JWTController::class, 'show'])->name('jwt.show');
//Wiki
Route::get('/wiki', [WikiController::class, 'index']);
Route::get('/wiki-today/{set?}/{date?}', [WikiController::class, 'onThisDay']);
//SQLBox
Route::get('/sqlbox', [SQLController::class, 'index']);
//Archive
Route::get('/archive', [ArchiveController::class, 'index']);
Route::post('/archive-search', [ArchiveController::class, 'getList'])->name('archive.search');
//World Bank
Route::get('/worldbank', [WorldBankController::class, 'index']);
Route::get('/worldbank/search', [WorldBankController::class, 'search'])->name('worldbank.search');
//Training
Route::get('/training', [TrainingController::class, 'index']);
//Social
Route::get('/social', [SocialController::class, 'index'])->name('social.index');
//Bio
Route::get('/bio', [BioController::class, 'index'])->name('bio.index');
Route::get('/bio/info', [BioController::class, 'info'])->name('bio.info');

