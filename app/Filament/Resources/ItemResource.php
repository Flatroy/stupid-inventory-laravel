<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Models\Item;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $slug = 'items';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ulid')
                    ->label('ULID')
                    ->disabled()
                    ->hiddenOn(['create']),

                Select::make('location_id')
                    ->relationship(name: 'location', titleAttribute: 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                        Textarea::make('description')->columnSpanFull()->rows(3)->autosize(),
                    ])
                    ->preload()
                    ->searchable()
                    ->required(),

                TextInput::make('name')
                    ->columnSpanFull()
                    ->required(),

                Textarea::make('description')->columnSpanFull()->rows(3)->autosize(),

                TextInput::make('import_ref'),

                TextInput::make('notes'),

                TextInput::make('quantity')
                    ->default(1)
                    ->required()
                    ->integer(),

                TextInput::make('asset_id')
                    ->integer(),

                Checkbox::make('insured'),

                Checkbox::make('archived'),

                TextInput::make('serial_number'),

                TextInput::make('model_number'),

                TextInput::make('manufacturer'),

                Checkbox::make('lifetime_warranty'),

                DatePicker::make('warranty_expires'),

                Textarea::make('warranty_details')->columnSpanFull()->rows(3)->autosize(),

                DatePicker::make('purchase_time'),

                TextInput::make('purchase_from'),

                TextInput::make('purchase_price')
                    ->numeric(),

                DatePicker::make('sold_time'),

                TextInput::make('sold_to'),

                TextInput::make('sold_price')
                    ->numeric(),

                Textarea::make('sold_notes')->columnSpanFull()->rows(3)->autosize(),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn (?Item $record): string => $record?->created_at?->diffForHumans() ?? '-')
                    ->hiddenOn(['create']),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn (?Item $record): string => $record?->updated_at?->diffForHumans() ?? '-')
                    ->hiddenOn(['create']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('ulid'),

                TextInputColumn::make('name')
                    ->searchable()
                    ->sortable(),

                // TextColumn::make('description')->searchable(),

                // TextColumn::make('import_ref')->searchable(),

                // TextColumn::make('notes')->searchable(),

                TextInputColumn::make('quantity')->searchable(),

                CheckboxColumn::make('insured'),

                CheckboxColumn::make('archived'),

                TextColumn::make('asset_id')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Asset ID copied')
                    ->copyMessageDuration(1500),
                //
                //                TextColumn::make('serial_number')->searchable(),
                //
                //                TextColumn::make('model_number')->searchable(),
                //
                //                TextColumn::make('manufacturer')->searchable(),
                //
                //                TextColumn::make('lifetime_warranty'),
                //
                //                TextColumn::make('warranty_expires')
                //                    ->date(),
                //
                //                TextColumn::make('warranty_details'),
                //
                //                TextColumn::make('purchase_time')
                //                    ->date(),
                //
                //                TextColumn::make('purchase_from')->searchable(),
                //
                //                TextColumn::make('purchase_price')->searchable(),
                //
                //                TextColumn::make('sold_time')
                //                    ->date(),
                //
                //                TextColumn::make('sold_to')->searchable(),
                //
                //                TextColumn::make('sold_price')->searchable(),
                //
                //                TextColumn::make('sold_notes')->searchable(),

                TextColumn::make('location.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['location']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'location.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->location) {
            $details['Location'] = $record->location->name;
        }

        return $details;
    }
}
