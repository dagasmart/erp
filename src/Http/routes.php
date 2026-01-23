<?php

use DagaSmart\Erp\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('erp', [Controllers\ErpController::class, 'index']);
