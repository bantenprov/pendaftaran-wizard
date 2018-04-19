<?php

Route::group(['prefix' => 'api/pendaftaran-wizard', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@index',
        'create'    => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@create',
        'show'      => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@show',
        'store'     => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@store',
        'edit'      => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@edit',
        'update'    => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@update',
        'destroy'   => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('pendaftaran-wizard.index');
    Route::get('/create',       $controllers->create)->name('pendaftaran-wizard.create');
    Route::get('/{id}',         $controllers->show)->name('pendaftaran-wizard.show');
    Route::post('/',            $controllers->store)->name('pendaftaran-wizard.store');
    Route::get('/{id}/edit',    $controllers->edit)->name('pendaftaran-wizard.edit');
    Route::put('/{id}',         $controllers->update)->name('pendaftaran-wizard.update');
    Route::delete('/{id}',      $controllers->destroy)->name('pendaftaran-wizard.destroy');
});

Route::group(['prefix' => 'api/pendaftaran', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@index',
        'create'    => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@create',
        'show'      => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@show',
        'store'     => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@store',
        'edit'      => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@edit',
        'update'    => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@update',
        'destroy'   => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('pendaftaran.index');
    Route::get('/create',       $controllers->create)->name('pendaftaran.create');
    Route::get('/{id}',         $controllers->show)->name('pendaftaran.show');
    Route::post('/',            $controllers->store)->name('pendaftaran.store');
    Route::get('/{id}/edit',    $controllers->edit)->name('pendaftaran.edit');
    Route::put('/{id}',         $controllers->update)->name('pendaftaran.update');
    Route::delete('/{id}',      $controllers->destroy)->name('pendaftaran.destroy');
});

Route::group(['prefix' => 'api/siswa', 'middleware' => ['web']], function() {
    $class          = 'Bantenprov\PendaftaranWizard\Http\Controllers\SiswaController';
    $name           = 'siswa';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];
    Route::get('/',             $controllers->index)->name($name.'.index');
    Route::get('/create',       $controllers->create)->name($name.'.create');
    Route::get('/{id}',         $controllers->show)->name($name.'.show');
    Route::post('/',            $controllers->store)->name($name.'.store');
    Route::get('/{id}/edit',    $controllers->edit)->name($name.'.edit');
    Route::put('/{id}',         $controllers->update)->name($name.'.update');
    Route::delete('/{id}',      $controllers->destroy)->name($name.'.destroy');
});
