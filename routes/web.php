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
    Route::redirect('/dashboard', '/app')->name('dashboard');
});

Route::get('/a/{asset_id}', function (string $asset_id) {
    $team_id = auth()?->user()?->currentTeam()?->getChild()?->id;
    // todo: put this logic in one place
    $asset_id = ltrim($asset_id, '0');
    $asset_id = ltrim($asset_id, '-');

    $asset = \App\Models\Item::where('asset_id', $asset_id)
        ->where('team_id', $team_id)
        ->first();
    if (! $asset) {
        // create new empty one with this asset id
        $asset = new \App\Models\Item();
        $asset->asset_id = $asset_id;
        $asset->team_id = $team_id;
        $asset->save();
    }

    return redirect()->to(ItemResource::getUrl('edit', ['record' => $asset, 'tenant' => $team_id]));
})->name('asset');
