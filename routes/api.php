<?php

use App\Http\Controllers\ApiController;
use App\Models\Appointment;
use App\Models\Day;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


    Route::get('/available-appointments', function (Request $request) {
        $inputDate = $request->input('date'); // تاريخ الدخل

        // التحقق من تاريخ صالح
        if (!$inputDate) {
            return response()->json(['error' => 'تاريخ غير صالح'], 400);
        }

        $formattedDate = Carbon::parse($inputDate)->toDateString(); // تنسيق التاريخ
        $dayName = Carbon::parse($inputDate)->format('l'); // اسم اليوم باللغة الإنجليزية
        $day_id = Day::select('id')->where('name_en' ,'LIKE' , "$dayName")->first()['id'] ?? 1;

        // الحصول على المواعيد المتاحة لهذا اليوم
        $availableAppointments = Appointment::where('day_id', $day_id)->get();

        return response()->json($availableAppointments, 200);
    });

    Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [ApiController::class, 'getCategories']);
    });


    Route::post('/storeOrder', [ApiController::class, 'storeOrder']);


    Route::group(['prefix' => 'products'], function () {
            Route::get('/{id}', [ApiController::class, 'getProductsId']);
            Route::get('/', [ApiController::class, 'getProducts']);
    });

    
    Route::get('/getImageHome', [ApiController::class, 'getImageHome']);


        Route::group(['prefix' => 'country'], function () {
            Route::get('/', [ApiController::class, 'getcountry']);
            Route::get('/{id}', [ApiController::class, 'getCountryid']);

            });




    Route::group(['prefix' => '/email-send'], function () {
        Route::post('/', [ApiController::class, 'email_send']);
    });


