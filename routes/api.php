<?php

use App\Http\Controllers\Smart_QRCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserLocationController;
###########################################################USER_AUTH########################################################################################


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
###########################################################QR-CODE########################################################################################


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/generate-qrcode', [QRCodeController::class, 'generateQRCode']);
});


Route::get('/qrcodes/{id}/check-visitor-count', [QRCodeController::class, 'checkVisitorCount']);

###########################################################USER_Dashboard"QR_CODE"########################################################################################

Route::get('/qrcodes/{user_id}', [Smart_QRCodeController::class, 'getQRCodeByUserId']);
Route::delete('/qrcode/{id}', [Smart_QRCodeController::class, 'deleteQRCodeById']);

###########################################################Smart_QRCode########################################################################################
Route::middleware('auth:sanctum')->group(function () {
Route::post('/qrcode/smart', [Smart_QRCodeController::class, 'generatesmartQRCode']);
});
#********************************************************USER_PROFILE*************************************************************************************************


Route::get('/profiles/{user_id}', [UserProfileController::class, 'getAllProfilesByUserId']);
Route::get('/profile/{id}', [UserProfileController::class, 'getProfileById']);
Route::get('/profile/qrcode/{qrCodeName}', [UserProfileController::class, 'getProfileByQRCodeName']);

#********************************************************USER_location*************************************************************************************************


Route::get('user-locations/{user_id}/{qrcode_id}', [UserLocationController::class, 'getUserLocationByUserIdAndQRCodeId']);
Route::post('/track/{id}', [UserLocationController::class, 'trackQRCode']);
###########################################################Package########################################################################################




Route::post('/packages', [PackageController::class, 'store']);  // Add a package
Route::get('/packages', [PackageController::class, 'index']);   // Get all packages
Route::get('/packages/{id}', [PackageController::class, 'show']);  // Get a specific package
Route::put('/packages/{id}', [PackageController::class, 'update']); // Update a package
Route::delete('/packages/{id}', [PackageController::class, 'destroy']); // Delete a package




###########################################################USER_SUBSCRIPTION########################################################################################




Route::post('/subscriptions', [SubscriptionController::class, 'store']);  // Create a subscription
Route::get('/subscriptions/user/{userId}', [SubscriptionController::class, 'getByUserId']);  // Get subscriptions by user ID
Route::get('/subscriptions/package/{packageId}', [SubscriptionController::class, 'getByPackageId']);  // Get subscriptions by package ID
Route::post('/subscriptions/validate', [SubscriptionController::class, 'validateSubscriptions']);  // Validate and disable expired subscriptions
###########################################################USER_SUBSCRIPTION########################################################################################
