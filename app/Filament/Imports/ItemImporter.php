<?php

namespace App\Filament\Imports;

use App\Models\Item;
use App\Models\Location;
use App\Models\Team;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Facades\Filament;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class ItemImporter extends Importer
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'nullable']),
            ImportColumn::make('description'),
            ImportColumn::make('import_ref'),
            ImportColumn::make('notes'),
            ImportColumn::make('quantity')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('insured')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('archived')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('asset_id')
                ->castStateUsing(function (string $state) {
                    // find from 000-001 integer value
                    if (blank($state)) {
                        return null;
                    }
                    // remove any non-numeric characters
                    $state = preg_replace('/[^0-9]/', '', $state);

                    return (int)$state;
                })
                ->rules([
                    'required',
//                    \Illuminate\Validation\Rule::unique('items', 'asset_id')
//                        ->where(function ($query) {
//                            return $query->andWhere('team_id', Filament::auth()->user()->currentTeam->id);
//                        })
                ]),
            ImportColumn::make('serial_number'),
            ImportColumn::make('model_number'),
            ImportColumn::make('manufacturer'),
            ImportColumn::make('lifetime_warranty')
                ->boolean()
                ->rules(['boolean', 'nullable']),
            ImportColumn::make('warranty_expires')
                ->rules(['date', 'nullable']),
            ImportColumn::make('warranty_details'),
            ImportColumn::make('purchase_time')
                ->rules(['date', 'nullable']),
            ImportColumn::make('purchase_from'),
            ImportColumn::make('purchase_price')
                ->numeric()
                ->numeric(decimalPlaces: 2)
                ->rules(['integer', 'nullable']),
            ImportColumn::make('sold_time')
                ->rules(['date', 'nullable']),
            ImportColumn::make('sold_to'),
            ImportColumn::make('sold_price')
                ->numeric(decimalPlaces: 2)
                ->numeric()
                ->rules(['integer', 'nullable']),
            ImportColumn::make('sold_notes'),
            ImportColumn::make('location')
                ->requiredMapping()
                ->relationship(resolveUsing: function (string $state
                ): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model {
                    // find the location by name or id OR create a new location
                    // TODO check team_id
                    return Location::query()
                        ->where('name', $state)
                        ->orWhere('id', $state)
                        ->firstOr(function () use ($state) {
                            return Location::create([
                                'name' => $state,
                            ]);
                        });
                })
                ->rules(['required', 'nullable']),
        ];
    }

    public function resolveRecord(): ?Item
    {
//        return Item::firstOrNew([
//            // Update existing records, matching them by `$this->data['column_name']`
//            'asset_id' => $this->data['asset_id'],
//            'team_id' => Filament::auth()->user()->currentTeam->id,
//        ]);
        $item = new Item();
        $item->team_id = $this->options['team_id'];
        return $item;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your item import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }


    protected function beforeCreate(): void
    {
    }

    protected function beforeFill(): void
    {
    }
}
