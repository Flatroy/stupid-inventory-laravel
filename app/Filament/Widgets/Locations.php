<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\LocationResource;
use App\Models\Location;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Locations extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(LocationResource::getEloquentQuery()->where('parent_id', null))
            ->defaultPaginationPageOption(15)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('name')
                        ->searchable()->sortable(),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn (Location $record): string => LocationResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
