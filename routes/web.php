<?php

use App\Filament\Resources\ItemResource;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    /*Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');*/
    Route::redirect('/dashboard', '/app')->name('dashboard');
});
//asset_id
Route::get('/a/{asset_id}', function (string $asset_id) {
    $asset = \App\Models\Item::where('asset_id', $asset_id)->first();
    if (! $asset) {
        // create new empty one with this asset id
        $asset = new \App\Models\Item();
        $asset->asset_id = $asset_id;
        $asset->team_id = auth()?->user()?->currentTeam()?->getChild()?->id;
        $asset->save();
    }

    return redirect()->to(ItemResource::getUrl('edit', ['record' => $asset]));
})->name('asset');
