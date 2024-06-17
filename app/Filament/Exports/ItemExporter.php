<?php

namespace App\Filament\Exports;

use App\Models\Item;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ItemExporter extends Exporter
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('ulid'),
            ExportColumn::make('name'),
            ExportColumn::make('description'),
            ExportColumn::make('import_ref'),
            ExportColumn::make('notes'),
            ExportColumn::make('quantity'),
            ExportColumn::make('insured'),
            ExportColumn::make('archived'),
            ExportColumn::make('asset_id'),
            ExportColumn::make('serial_number'),
            ExportColumn::make('model_number'),
            ExportColumn::make('manufacturer'),
            ExportColumn::make('lifetime_warranty'),
            ExportColumn::make('warranty_expires'),
            ExportColumn::make('warranty_details'),
            ExportColumn::make('purchase_time'),
            ExportColumn::make('purchase_from'),
            ExportColumn::make('purchase_price'),
            ExportColumn::make('sold_time'),
            ExportColumn::make('sold_to'),
            ExportColumn::make('sold_price'),
            ExportColumn::make('sold_notes'),
            ExportColumn::make('location.name'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your item export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
