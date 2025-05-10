<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/test-session', function () {
    session(['filament-language-switch-locale' => 'ar']);
    return session('filament-language-switch-locale');
});
