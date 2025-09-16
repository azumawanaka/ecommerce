<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::get('products', function () {
        return Inertia::render('products/index');
    })->name('products');

    Route::get('categories', function () {
        return Inertia::render('products/categories/index');
    })->name('categories');

    Route::get('brands', function () {
        return Inertia::render('products/brands/index');
    })->name('brands');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
