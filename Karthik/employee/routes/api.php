<?php

use App\Http\Controllers\employeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [employeeController::class, 'login']);
Route::post('/AddEmployee', [employeeController::class, 'AddEmployee']);
Route::post('/getEmployees', [employeeController::class, 'getEmployees']);
Route::post('/getEmployeeDetails', [employeeController::class, 'getEmployeeDetails']);
Route::post('/editEmployee/{employee}', [employeeController::class, 'editEmployee']);
Route::post('/removeEmployee/{employee}', [employeeController::class, 'removeEmployee']);
Route::post('/AddLeave', [employeeController::class, 'AddLeave']);
Route::post('/GetEmployeeLeaves', [employeeController::class, 'GetEmployeeLeaves']);

