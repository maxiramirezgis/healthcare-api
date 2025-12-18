<?php

declare(strict_types=1);

use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Route;
use Lightit\Users\App\Controllers\{
    GetUserController,
    DeleteUserController,
    ListUserController,
    StoreUserController,
    UpdateUserController
};
use Lightit\Clinic\App\Controllers\{
    AttachDoctorToClinicController,
    DeleteClinicController,
    DetachDoctorFromClinicController,
    GetClinicController,
    ListClinicDoctorsController,
    StoreClinicController,
    UpdateClinicController
};
use Lightit\Doctor\App\Controllers\{
    DeleteDoctorController,
    GetDoctorController,
    StoreDoctorController,
    UpdateDoctorController};

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

Route::middleware('auth:sanctum')
    ->get('/me', fn(
        #[CurrentUser] $user
    ) => response()->json([
        'data' => $user,
    ]));

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
Route::prefix('users')
    ->group(static function (): void {
        Route::get('/', ListUserController::class);
        Route::post('/', StoreUserController::class);
        Route::prefix('{user}')->group(static function (): void {
            Route::get('/', GetUserController::class)->withTrashed();
            Route::put('/', UpdateUserController::class);
            Route::delete('/', DeleteUserController::class);
        })->whereNumber('user');
    });

/*
|--------------------------------------------------------------------------
| Clinics Routes
|--------------------------------------------------------------------------
*/

Route::prefix('clinics')
    ->group(static function (): void {
        Route::post('/', StoreClinicController::class);
        Route::prefix('{clinic}')->group(static function (): void {
            Route::get('/', GetClinicController::class);
            Route::put('/', UpdateClinicController::class);
            Route::delete('/', DeleteClinicController::class);
            Route::prefix('doctors')->group(static function (): void {
                Route::get('/', ListClinicDoctorsController::class);
                Route::post('/', AttachDoctorToClinicController::class);
                Route::delete('{doctor}', DetachDoctorFromClinicController::class)
                    ->whereNumber('doctor');
            });
        })->whereNumber('clinic');
    });

/*
|--------------------------------------------------------------------------
| Doctors Routes
|--------------------------------------------------------------------------
*/

Route::prefix('doctors')
    ->group(static function (): void {
        Route::post('/', StoreDoctorController::class);
        Route::prefix('{doctor}')->group(static function (): void {
            Route::get('/', GetDoctorController::class);
            Route::put('/', UpdateDoctorController::class);
            Route::delete('/', DeleteDoctorController::class);
        })->whereNumber('doctor');
    });
