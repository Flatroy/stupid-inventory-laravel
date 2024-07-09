<?php

namespace App\Filament\Widgets;

use App\Filament\Exports\ItemExporter;
use App\Filament\Imports\ItemImporter;
use App\Filament\Resources\ItemResource;
use App\Models\Item;
use Filament\Facades\Filament;
use Filament\Infolists\Components\ImageEntry;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecentlyAdded extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getEloquentQuery())
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

                Action::make('ShowQrCode')
                    ->iconButton()
                    ->icon('heroicon-o-qr-code')
                    ->modalHeading('QR Code:')
                    ->action(function () {})
                    ->label('Show QR Code')
                    ->modalSubmitAction(false)
                    ->modalWidth(MaxWidth::Small)
                    ->modalCancelAction(fn ($action) => $action->label('Close'))
                    ->infolist([
                        ImageEntry::make('qr_code_url')->size(300)->label(''),
                    ]),

                Tables\Actions\Action::make('open')
                    ->icon('heroicon-m-pencil-square')
                    ->url(fn (Item $record): string => ItemResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(ItemImporter::class)->options([
                        'team_id' => Filament::getTenant()?->id,
                    ]),
                ExportAction::make()->exporter(ItemExporter::class),
            ])
            ->filters([
                SelectFilter::make('location_id')
                    ->relationship('location', 'name')
                    ->label('Location')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('tags')
                    ->label('Label')
                    ->relationship('tags', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload(),

                TrashedFilter::make(),
            ])
            ->filtersLayout(FiltersLayout::AboveContentCollapsible)
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);

    }

    public static function getEloquentQuery(): EloquentBuilder
    {
        return ItemResource::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
