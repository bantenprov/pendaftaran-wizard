<?php

Route::group(['prefix' => 'api/pendaftaran-wizard', 'middleware' => ['web','auth:api']], function() {
    $controllers = (object) [
        'create'    => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranWizardController@create',
        'store'     => 'Bantenprov\PendaftaranWizard\Http\Controllers\PendafataranExecuteController@execute',
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

Route::group(['prefix' => 'api/jenis-sekolah', 'middleware' => ['web','auth:api']], function() {
    $class          = 'Bantenprov\PendaftaranWizard\Http\Controllers\JenisSekolahController';
    $name           = 'jenis-sekolah';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];
    Route::get('/',             $controllers->index)->name($name.'.index');
    Route::get('/get',          $controllers->get)->name($name.'.get');
    Route::get('/create',       $controllers->create)->name($name.'.create');
    Route::get('/{id}',         $controllers->show)->name($name.'.show');
    Route::post('/',            $controllers->store)->name($name.'.store');
    Route::get('/{id}/edit',    $controllers->edit)->name($name.'.edit');
    Route::put('/{id}',         $controllers->update)->name($name.'.update');
    Route::delete('/{id}',      $controllers->destroy)->name($name.'.destroy');
});
Route::group(['prefix' => 'api/sekolah', 'middleware' => ['web','auth:api']], function() {
    $class          = 'Bantenprov\PendaftaranWizard\Http\Controllers\SekolahController';
    $name           = 'sekolah';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];
    Route::get('/',             $controllers->index)->name($name.'.index');
    Route::get('/get',          $controllers->get)->name($name.'.get');
    Route::get('/create',       $controllers->create)->name($name.'.create');
    Route::get('/{id}',         $controllers->show)->name($name.'.show');
    Route::post('/',            $controllers->store)->name($name.'.store');
    Route::get('/{id}/edit',    $controllers->edit)->name($name.'.edit');
    Route::put('/{id}',         $controllers->update)->name($name.'.update');
    Route::delete('/{id}',      $controllers->destroy)->name($name.'.destroy');
});
Route::group(['prefix' => 'api/prodi-sekolah', 'middleware' => ['web','auth:api']], function() {
    $class          = 'Bantenprov\PendaftaranWizard\Http\Controllers\ProdiSekolahController';
    $name           = 'prodi-sekolah';
    $controllers    = (object) [
        'index'         => $class.'@index',
        'get'           => $class.'@get',
        'getBySekolah'  => $class.'@getBySekolah',
        'create'        => $class.'@create',
        'show'          => $class.'@show',
        'store'         => $class.'@store',
        'edit'          => $class.'@edit',
        'update'        => $class.'@update',
        'destroy'       => $class.'@destroy',
    ];
    Route::get('/',                     $controllers->index)->name($name.'.index');
    Route::get('/get',                  $controllers->get)->name($name.'.get');
    Route::get('/get/by-sekolah/{id}',  $controllers->getBySekolah)->name($name.'.get-by-sekolah');
    Route::get('/create',               $controllers->create)->name($name.'.create');
    Route::get('/{id}',                 $controllers->show)->name($name.'.show');
    Route::post('/',                    $controllers->store)->name($name.'.store');
    Route::get('/{id}/edit',            $controllers->edit)->name($name.'.edit');
    Route::put('/{id}',                 $controllers->update)->name($name.'.update');
    Route::delete('/{id}',              $controllers->destroy)->name($name.'.destroy');
});

Route::group(['prefix' => 'check-peserta', 'middleware' => ['web']], function(){
    Route::get('/{nomor_un}', 'Bantenprov\PendaftaranWizard\Http\Controllers\PendaftaranController@checkPeserta')->name('check_peserta');
});

Route::group(['prefix' => 'api/prestasi', 'middleware' => ['auth:api', 'web']], function() {
    $class          = 'Bantenprov\PendaftaranWizard\Http\Controllers\PrestasiController';
    $name           = 'prestasi';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
    ];
    Route::get('/',             $controllers->index)->name($name.'.index');
    Route::get('/get',          $controllers->get)->name($name.'.get');
    Route::get('/create',       $controllers->create)->name($name.'.create');
});

Route::group(['prefix' => 'api/master-sktm', 'middleware' => ['auth:api', 'web']], function() {
    $class          = 'Bantenprov\PendaftaranWizard\Http\Controllers\MasterSktmController';
    $name           = 'master-sktm';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];
    Route::get('/',             $controllers->index)->name($name.'.index');
    Route::get('/get',          $controllers->get)->name($name.'.get');
    Route::get('/create',       $controllers->create)->name($name.'.create');
    Route::get('/{id}',         $controllers->show)->name($name.'.show');
    Route::post('/',            $controllers->store)->name($name.'.store');
    Route::get('/{id}/edit',    $controllers->edit)->name($name.'.edit');
    Route::put('/{id}',         $controllers->update)->name($name.'.update');
    Route::delete('/{id}',      $controllers->destroy)->name($name.'.destroy');
});

