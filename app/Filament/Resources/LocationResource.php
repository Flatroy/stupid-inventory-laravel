<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms\Components\Checkbox;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $slug = 'locations';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->required(),

                Select::make('parent_id')->label('Parent Location')
                    ->relationship(name: 'parent', titleAttribute: 'name', ignoreRecord: true)
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),
                        Textarea::make('description')->columnSpanFull()->rows(3)->autosize(),
                    ]),

                Textarea::make('description')->columnSpanFull()->rows(3)->autosize(),

                // Checkbox::make('is_active')->default(true),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn (?Location $record): string => $record?->created_at?->diffForHumans() ?? '-')
                    ->hiddenOn(['create']),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn (?Location $record): string => $record?->updated_at?->diffForHumans() ?? '-')
                    ->hiddenOn(['create']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description'),

                TextColumn::make('parent.name'),

                // TextColumn::make('is_active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            // to make separate pages you can uncomment this:
            /*'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),*/
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
