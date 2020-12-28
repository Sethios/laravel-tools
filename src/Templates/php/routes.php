
    // ¤ModelP¤ pages
    Route::group(['prefix' => '¤-model¤'], function() {
        Route::get('/', [
            'as' => '¤_model¤.index',
            'uses' => '¤ModelP¤Controller@index',
            'middleware' => ['permission:view ¤_model¤|view_all ¤_model¤']
        ]);
        Route::get('/new', [
            'as' => '¤_model¤.new',
            'uses' => '¤ModelP¤Controller@new',
            'middleware' => ['permission:create ¤_model¤']
        ]);
        Route::put('/store', [
            'as' => '¤_model¤.store',
            'uses' => '¤ModelP¤Controller@store',
            'middleware' => ['permission:create ¤_model¤']
        ]);
        Route::get('/edit', [
            'as' => '¤_model¤.edit',
            'uses' => '¤ModelP¤Controller@edit',
            'middleware' => ['permission:edit ¤_model¤']
        ]);
        Route::patch('/update', [
            'as' => '¤_model¤.update',
            'uses' => '¤ModelP¤Controller@update',
            'middleware' => ['permission:edit ¤_model¤']
        ]);
        Route::delete('/delete', [
            'as' => '¤_model¤.delete',
            'uses' => '¤ModelP¤Controller@delete',
            'middleware' => ['permission:delete ¤_model¤']
        ]);
        Route::get('/download', [
            'as' => '¤_model¤.download',
            'uses' => '¤ModelP¤Controller@download',
            'middleware' => ['permission:download ¤_model¤_csv']
        ]);
        Route::post('/import', [
            'as' => '¤_model¤.importSave',
            'uses' => '¤ModelP¤Controller@importSave',
            'middleware' => ['permission:import ¤_model¤_csv']
        ]);
    });