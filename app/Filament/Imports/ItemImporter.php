<?php

namespace App\Filament\Imports;

use App\Models\Item;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ItemImporter extends Importer
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('ulid')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required']),
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
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('serial_number'),
            ImportColumn::make('model_number'),
            ImportColumn::make('manufacturer'),
            ImportColumn::make('lifetime_warranty')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('warranty_expires')
                ->rules(['datetime']),
            ImportColumn::make('warranty_details'),
            ImportColumn::make('purchase_time')
                ->rules(['datetime']),
            ImportColumn::make('purchase_from'),
            ImportColumn::make('purchase_price')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('sold_time')
                ->rules(['datetime']),
            ImportColumn::make('sold_to'),
            ImportColumn::make('sold_price')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('sold_notes'),
            ImportColumn::make('location')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): ?Item
    {
        // return Item::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Item();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your item import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
