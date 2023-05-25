<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BandController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\DrummerController;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::ApiResource('bands', BandController::class)->only("index", "show");
Route::get('bands/{band}/drummers', [BandController::class, 'drummers'])->name('bands.drummers');

Route::ApiResource('merken', BrandController::class)->parameters(['merken' => 'brand'])->only("index", "show");
Route::get('merken/{brand}/onderdelen', [BrandController::class, 'components'])->name('brand.conponents');

Route::ApiResource('onderdelen', ComponentController::class)->parameters(['onderdelen' => 'component'])->only("index", "show");
Route::get('onderdelen/{component}/drummers', [ComponentController::class, 'drummers'])->name('component.drummers');
Route::get('onderdelen/{component}/merk', [ComponentController::class, 'brand'])->name('component.brand');

Route::ApiResource('drummers', DrummerController::class)->only("index", "show");
Route::get('drummers/{drummer}/bands', [DrummerController::class, 'bands'])->name('drummers.bands');
Route::get('drummers/{drummer}/onderdelen', [DrummerController::class, 'components'])->name('drummers.components');

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::ApiResource('bands', BandController::class)->except("index", "show");
    Route::delete('bands/{band}/drummers/{drummer}', [BandController::class, 'removeDrummer'])->name('bands.removeDrummers');
    
    Route::ApiResource('merken', BrandController::class)->parameters(['merken' => 'brand'])->except("index", "show");
    Route::delete('merken/{brand}/onderdelen/{compartment}', [BrandController::class, 'removeComponent'])->name('brand.removeComponent');
        
    Route::ApiResource('onderdelen', ComponentController::class)->parameters(['onderdelen' => 'component'])->except("index", "show");
    Route::post('onderdelen/{component}/merk/{brand}', [ComponentController::class, 'addToBrand'])->name('component.addToBrand');
    Route::delete('onderdelen/{component}/merk/{brand}', [ComponentController::class, 'removeFromBrand'])->name('component.removeFromBrand');
    Route::post('onderdelen/{component}/drummers/{drummer}', [ComponentController::class, 'addDrummer'])->name('component.addDrummer');
    Route::delete('onderdelen/{component}/drummers/{drummer}', [ComponentController::class, 'removeDrummer'])->name('component.removeDrummer');

    Route::ApiResource('drummers', DrummerController::class)->except("index", "show");
    Route::post('drummers/{drummer}/bands/{band}', [DrummerController::class, 'addToBand'])->name('drummers.addToBand');
    Route::delete('drummers/{drummer}/bands/{band}', [DrummerController::class, 'removeFromBand'])->name('drummers.removeFromBand');
    Route::post('drummers/{drummer}/onderdelen/{compartment}', [DrummerController::class, 'addComponent'])->name('drummers.addComponent');
    Route::delete('drummers/{drummer}/onderdelen/{compartment}', [DrummerController::class, 'removeComponent'])->name('drummers.removeComponent');

    Route::get('profile', function(Request $request) { return auth()->user(); });
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});