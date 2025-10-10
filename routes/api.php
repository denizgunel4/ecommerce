<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\VariantValueController;
use App\Http\Controllers\CustomerController;

//Product
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products/add', [ProductController::class, 'store']);
Route::put('/products/update/{product}', [ProductController::class, 'update']);
Route::delete('/products/delete/{product}', [ProductController::class, 'destroy']);

//Category
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories/add', [CategoryController::class, 'store']);
Route::put('/categories/update/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/delete/{category}', [CategoryController::class, 'destroy']);

//Brand
Route::get('/brands', [BrandController::class, 'index']);
Route::post('/brands/add', [BrandController::class, 'store']);
Route::put('/brands/update/{brand}', [BrandController::class, 'update']);
Route::delete('/brands/delete/{brand}', [BrandController::class, 'destroy']);

//Variant
Route::get('/variants', [VariantController::class, 'index']);
Route::post('/variants/add', [VariantController::class, 'store']);
Route::put('/variants/update/{variant}', [VariantController::class, 'update']);
Route::delete('/variants/delete/{variant}', [VariantController::class, 'destroy']);

//Variant Value
Route::get('/variant-values', [VariantValueController::class, 'index']);
Route::post('/variant-values/add', [VariantValueController::class, 'store']);
Route::delete('/variant-values/delete/{variantValue}', [VariantValueController::class, 'destroy']);

//Customer
Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers/add', [CustomerController::class, 'store']);
Route::put('/customers/update/{customer}', [CustomerController::class, 'update']);
Route::delete('/customers/delete/{customer}', [CustomerController::class, 'destroy']);
