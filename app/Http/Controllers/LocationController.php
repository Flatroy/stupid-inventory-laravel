<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Location::class);

        return LocationResource::collection(Location::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Location::class);

        $data = $request->validate([
            'name' => ['required'],
            'description' => ['nullable'],
            'parent_id' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return new LocationResource(Location::create($data));
    }

    public function show(Location $location)
    {
        $this->authorize('view', $location);

        return new LocationResource($location);
    }

    public function update(Request $request, Location $location)
    {
        $this->authorize('update', $location);

        $data = $request->validate([
            'name' => ['required'],
            'description' => ['nullable'],
            'parent_id' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $location->update($data);

        return new LocationResource($location);
    }

    public function destroy(Location $location)
    {
        $this->authorize('delete', $location);

        $location->delete();

        return response()->json();
    }
}
