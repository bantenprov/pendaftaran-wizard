<?php

Route::group(['prefix' => 'api/pendaftaran-wizard', 'middleware' => ['web','auth:api']], function() {
    $controllers = (object) [
        'create'    => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@create',
        'store'     => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@store',
    ];

    Route::get('/create',       $controllers->create)->name('pendaftaran-wizard.create');
    Route::post('/',            $controllers->store)->name('pendaftaran-wizard.store');
});

Route::group(['prefix' => 'api/pendaftaran', 'middleware' => ['web','auth:api']], function() {
    $controllers = (object) [
        'create'    => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@create',
        'store'     => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@store',
    ];

    Route::get('/create',       $controllers->create)->name('pendaftaran.create');
    Route::post('/',            $controllers->store)->name('pendaftaran.store');
});

Route::group(['prefix' => 'api/siswa', 'middleware' => ['web','auth:api']], function() {
    $class          = 'Bantenprov\PendaftaranWizard\Http\Controllers\SiswaController';
    $name           = 'siswa';
    $controllers    = (object) [
        'create'    => $class.'@create',
        'store'     => $class.'@store',
    ];
    Route::get('/create',       $controllers->create)->name($name.'.create');
    Route::post('/',            $controllers->store)->name($name.'.store');
});


Route::group(['prefix' => 'api/orang-tua', 'middleware' => ['web','auth:api']], function() {
    $controllers = (object) [
        'create'    => 'Bantenprov\PendaftaranWizard\Http\Controllers\OrangTuaController@create',
        'store'     => 'Bantenprov\PendaftaranWizard\Http\Controllers\OrangTuaController@store',
    ];
    Route::get('/create',       $controllers->create)->name('orang-tua.create');
    Route::post('/',            $controllers->store)->name('orang-tua.store');
});
