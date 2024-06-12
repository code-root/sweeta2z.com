<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


        Route::get('/clear', function () {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('config:cache');
            Artisan::call('view:clear');
            Artisan::call('optimize:clear');
            return "Cleared cache , config , view , optimize !";
        });

    Route::get('/logout', function () {
         Auth::logout();
        return redirect('/login');
    });

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix'=>'dashboard'], function(){
        Route::get('/', [HomeController::class, 'index'])->name('dashboard-index');
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);


            Route::group(['prefix' => 'categories'], function () {
                Route::group(['middleware' => ['permission:view_categories']], function () {
                    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
                    Route::get('create/', [CategoryController::class, 'create'])->name('categories.create');
                    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
                    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
                    Route::get('{id}', [CategoryController::class, 'show'])->name('categories.show');
                    Route::put('{id}', [CategoryController::class, 'update'])->name('categories.update');
                    Route::delete('{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
                });
            });


            Route::group(['prefix' => 'days'], function () {
                Route::get('/', [AppointmentController::class, 'days'])->name('days.index');
                Route::get('/add_page', [AppointmentController::class, 'add_page'])->name('days.add');
                Route::get('/create', [AppointmentController::class, 'create'])->name('days.create');
                Route::post('/store', [AppointmentController::class, 'store'])->name('days.store');
               Route::get('/appointments', [AppointmentController::class, 'getAppointmentsByDay'])->name('days.appointments');
                  Route::delete('/appointments/delete', [AppointmentController::class, 'deleteAppointment'])->name('appointments.delete');
        });




            Route::group(['prefix' => 'orders'], function () {
                    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
            });


            Route::group(['prefix' => 'products'], function () {
                Route::group(['middleware' => ['permission:view_blog']], function () {
                    Route::get('/', [ProductController::class, 'index'])->name('products.index');
                    Route::get('create/', [ProductController::class, 'create'])->name('products.create');
                    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
                    Route::post('store/', [ProductController::class, 'store'])->name('products.store');
                    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');

                });
            });




            Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
            Route::get('/areas/create', [AreaController::class, 'create'])->name('areas.create');
            Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
            Route::get('/areas/{area}', [AreaController::class, 'show'])->name('areas.show');
            Route::get('/areas/{area}/edit', [AreaController::class, 'edit'])->name('areas.edit');
            Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');
            Route::delete('/areas/{area}', [AreaController::class, 'destroy'])->name('areas.destroy');

            // Country Routes
            Route::group(['prefix' => 'country'], function () {
                // Route::group(['middleware' => ['permission:view_country']], function () {
                    Route::get('create', [CountryController::class, 'create'])->name('country.create');
                    Route::get('edit/{id}', [CountryController::class, 'edit'])->name('country.edit');
                    Route::get('/', [CountryController::class, 'index'])->name('country.index');
                    Route::post('/', [CountryController::class, 'store'])->name('country.store');
                    Route::get('{id}', [CountryController::class, 'show'])->name('country.show');
                    Route::post('{id}', [CountryController::class, 'update'])->name('country.update');
                    Route::delete('{id}', [CountryController::class, 'destroy'])->name('country.destroy');




                // });
            });


        Route::group(['prefix'=>'image'], function(){
            Route::post('/upload', [ImageItemController::class, 'store'])->name('image.upload');
            Route::post('delete', [ImageItemController::class, 'delete'])->name('image.delete');
        });

    });
});


Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
