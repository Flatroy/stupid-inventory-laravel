<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\TagResource;
use App\Models\Tag;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class Labels extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(TagResource::getEloquentQuery())
            ->contentGrid([
                'md' => 3,
                'lg' => 4,
                'xl' => 5,
            ])
            ->columns([

                \Filament\Tables\Columns\Layout\View::make('filament.widgets.labels'),
            ])
            ->recordUrl(
                fn (Tag $record): string => \App\Filament\Resources\TagResource::getUrl('view', ['record' => $record]),
            )
            ->paginated([
                'limit' => 100,
            ])
            ->defaultPaginationPageOption(100)
            ->actions([])
            ->bulkActions([])
            ->emptyStateHeading('No labels found')
            ->emptyStateDescription('Create a new label to get started.')
            ->emptyStateIcon('heroicon-o-tag')
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('items'))
            ->defaultSort('items_count', 'desc');
    }
}
