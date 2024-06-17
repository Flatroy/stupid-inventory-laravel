<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Item::class);

        return ItemResource::collection(Item::all());
    }

    public function store(Request $request)
    {
        $this->authorize('create', Item::class);

        $data = $request->validate([
            'ulid' => ['required'],
            'name' => ['required'],
            'description' => ['nullable'],
            'import_ref' => ['nullable'],
            'notes' => ['nullable'],
            'quantity' => ['required', 'integer'],
            'insured' => ['nullable', 'boolean'],
            'archived' => ['nullable', 'boolean'],
            'asset_id' => ['nullable', 'integer'],
            'serial_number' => ['nullable'],
            'model_number' => ['nullable'],
            'manufacturer' => ['nullable'],
            'lifetime_warranty' => ['nullable', 'boolean'],
            'warranty_expires' => ['nullable', 'date'],
            'warranty_details' => ['nullable'],
            'purchase_time' => ['nullable', 'date'],
            'purchase_from' => ['nullable'],
            'purchase_price' => ['nullable', 'numeric'],
            'sold_time' => ['nullable', 'date'],
            'sold_to' => ['nullable'],
            'sold_price' => ['nullable', 'numeric'],
            'sold_notes' => ['nullable'],
            'location_id' => ['required', 'exists:locations'],
        ]);

        return new ItemResource(Item::create($data));
    }

    public function show(Item $item)
    {
        $this->authorize('view', $item);

        return new ItemResource($item);
    }

    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);

        $data = $request->validate([
            'ulid' => ['required'],
            'name' => ['required'],
            'description' => ['nullable'],
            'import_ref' => ['nullable'],
            'notes' => ['nullable'],
            'quantity' => ['required', 'integer'],
            'insured' => ['nullable', 'boolean'],
            'archived' => ['nullable', 'boolean'],
            'asset_id' => ['nullable', 'integer'],
            'serial_number' => ['nullable'],
            'model_number' => ['nullable'],
            'manufacturer' => ['nullable'],
            'lifetime_warranty' => ['nullable', 'boolean'],
            'warranty_expires' => ['nullable', 'date'],
            'warranty_details' => ['nullable'],
            'purchase_time' => ['nullable', 'date'],
            'purchase_from' => ['nullable'],
            'purchase_price' => ['nullable', 'numeric'],
            'sold_time' => ['nullable', 'date'],
            'sold_to' => ['nullable'],
            'sold_price' => ['nullable', 'numeric'],
            'sold_notes' => ['nullable'],
            'location_id' => ['required', 'exists:locations'],
        ]);

        $item->update($data);

        return new ItemResource($item);
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return response()->json();
    }
}
