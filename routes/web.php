<?php

use App\Http\Controllers\ListingController;
use Clockwork\Request\Request;
use Illuminate\Support\Facades\Redirect;
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

// redirect to "/listings" route when user hit the "/" route
Route::redirect('/', '/listings');

// Route::controller(ListingController::class)->group(function () {
// All Listing
// Route::get('/listings', 'index');

// Show Create Form
// Route::get('/listings/create', 'create');

// Store Listing Data
// Route::post('/listings', 'store');

// Single Listing
// Route::get('/listings/{listing}', 'show')
//   ->missing(function () {
//     return redirect('/', 301);
//   });

// Route::delete('/listings/{listing}', 'destroy');
// });


// Show Register/Create Form
Route::controller(UserController::class)->group(function() {
  Route::get('/register', 'register');
});

Route::resource('listings', ListingController::class);
  // ->missing(function () {
  //   return Redirect::route('listings.index', status: 301);
  // });

// Route::fallback(fn() => 'Halaman tidak ada');