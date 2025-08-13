<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WaInvitationController;

Route::redirect('/', '/upload');


Route::get('upload', [WaInvitationController::class, 'form']);
Route::post('verify-excel', [WaInvitationController::class, 'verifyExcel']);
Route::post('send-wa', [WaInvitationController::class, 'sendWaFromExcel']);
Route::get('download-template', [WaInvitationController::class, 'downloadTemplate']);
Route::get('manual-invitation', [WaInvitationController::class, 'manualForm']);
Route::post('manual-invitation', [WaInvitationController::class, 'manualResult']);
Route::get('verification', [WaInvitationController::class, 'showVerification']);
