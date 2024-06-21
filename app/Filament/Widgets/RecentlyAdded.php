<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ItemResource;
use App\Models\Item;
use Filament\Tables;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentlyAdded extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(ItemResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()->sortable()->toggleable(),

                TextInputColumn::make('quantity')->searchable()->rules(['integer'])->toggleable()->extraAttributes(['class' => 'w-32'])->type('number')->alignCenter(),

                Tables\Columns\TextColumn::make('location.name')->searchable()->sortable()->toggleable(),

                Tables\Columns\TextColumn::make('purchase_price')->searchable()->sortable()->toggleable(),

                Tables\Columns\CheckboxColumn::make('insured')->toggleable(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn (Item $record): string => ItemResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
