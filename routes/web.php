<?php



Route::get('/admin', function () {
    return redirect(\route('admin.dashboard'));
});

Route::get('/reception', function () {
    return redirect(\route('reception.dashboard'));
});

