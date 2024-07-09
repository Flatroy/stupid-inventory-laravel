<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ItemExporter;
use App\Filament\Imports\ItemImporter;
use App\Filament\Resources\ItemResource\Pages;
use App\Models\Item;
use Filament\Facades\Filament;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $slug = 'items';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('location_id')
                    ->relationship(name: 'location', titleAttribute: 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required(),

                        Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3)
                            ->autosize(),

                        Select::make('parent_id')
                            ->label('Parent Location')
                            ->relationship(
                                name: 'parent',
                                titleAttribute: 'name',
                                ignoreRecord: true
                            )
                            ->preload()
                            ->searchable(),
                    ])
                    ->preload()
                    ->searchable()
                    ->required(),

                SpatieTagsInput::make('tags')->label('Labels'),

                TextInput::make('ulid')
                    ->label('Unique ID')
                    ->disabled()
                    ->hiddenOn(['create']),

                TextInput::make('name')
                    ->label('Item name')
                    ->columnSpanFull()
                    ->autofocus()
                    ->required(),

                Textarea::make('description')
                    ->label('Item description')
                    ->columnSpanFull()
                    ->rows(5)->autosize(),

                Section::make('Advanced Details')
                    ->schema([

                        // todo: add attachments https://filamentphp.com/plugins/filament-spatie-media-library

                        TextInput::make('import_ref'),

                        Textarea::make('notes')->columnSpanFull()->rows(3)->autosize(),

                        \LaraZeus\Quantity\Components\Quantity::make('quantity')
                            ->default(1)
                            ->stacked()
                            ->label('Quantity')
                            ->required()
                            ->integer(),

                        TextInput::make('asset_id')
                            ->label('Asset ID')
                            // must be like 000-000 but stored as int
                            ->rules([
                                'unique:items,asset_id',
                                'required',
                            ]),

                        Checkbox::make('insured')->label('Insured'),

                        Checkbox::make('archived'),

                        TextInput::make('serial_number'),

                        TextInput::make('model_number'),

                        TextInput::make('manufacturer'),
                    ])
                    ->collapsible()->collapsed()->persistCollapsed()
                    ->hiddenOn(['create']),

                Section::make('Custom Fields')
                    ->schema([
                        Builder::make('fields')
                            ->label('')
                            ->blocks([
                                Builder\Block::make('text_field')
                                    ->schema([
                                        TextInput::make('name'),
                                        TextInput::make('value'),

                                    ])
                                    ->columns(2),
                                Builder\Block::make('paragraph_field')
                                    ->schema([
                                        TextInput::make('name'),

                                        Textarea::make('value')
                                            ->label('Value'),
                                    ]),
                                Builder\Block::make('image_field')
                                    ->schema([
                                        FileUpload::make('value')
                                            ->disk('r2')
                                            ->label('Image')
                                            ->openable()
                                            ->previewable()
                                            ->reorderable()
                                            ->appendFiles()
                                            ->imageEditor()
                                            ->downloadable()
                                            ->directory('image-attachments')
                                            ->visibility('private')
                                            ->image(),
                                        TextInput::make('name')
                                            ->label('Note'),
                                    ]),
                                Builder\Block::make('file_field')
                                    ->schema([
                                        FileUpload::make('value')
                                            ->disk('r2')
                                            ->label('File(s)')
                                            ->reorderable()
                                            ->directory('file_attachments')
                                            ->visibility('private')
                                            ->downloadable()
                                            ->appendFiles(),
                                        TextInput::make('name')
                                            ->label('Note'),
                                    ]),
                            ]),

                    ])
                    ->collapsible()
                    ->collapsed()
                    ->persistCollapsed()
                    ->hiddenOn(['create']),

                Section::make('Purchase Details')
                    ->schema([

                        DatePicker::make('purchase_time'),

                        TextInput::make('purchase_from'),

                        TextInput::make('purchase_price')
                            ->numeric(),

                    ])
                    ->collapsible()->collapsed()->persistCollapsed()
                    ->hiddenOn(['create']),
                Section::make('Warranty Information')
                    ->schema([
                        Checkbox::make('lifetime_warranty'),

                        DatePicker::make('warranty_expires'),

                        Textarea::make('warranty_details')->columnSpanFull()->rows(3)->autosize(),
                    ])
                    ->collapsible()->collapsed()->persistCollapsed()
                    ->hiddenOn(['create']),

                Section::make('Sold Details')
                    ->schema([

                        DatePicker::make('sold_time'),

                        TextInput::make('sold_to'),

                        TextInput::make('sold_price')
                            ->numeric(),

                        Textarea::make('sold_notes')->columnSpanFull()->rows(3)->autosize(),
                    ])
                    ->collapsible()->collapsed()->persistCollapsed()
                    ->hiddenOn(['create']),

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
                TextColumn::make('ulid')->toggleable(isToggledHiddenByDefault: true),

                SpatieTagsColumn::make('tags')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('import_ref')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('notes')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextInputColumn::make('quantity')->searchable()->rules(['integer'])->toggleable()->extraAttributes(['class' => 'w-32'])->type('number')->alignCenter(),

                CheckboxColumn::make('insured')->toggleable(),

                CheckboxColumn::make('archived')->toggleable(),

                TextColumn::make('asset_id')
                    ->label('Asset ID')
                    ->searchable(
                        /*query: function ($query, string $search) {
                            return $query->searchAssetId($search);
                        }*/
                    )
                    ->copyable()
                    ->copyMessage('Asset ID copied')
                    ->copyMessageDuration(1500)
                    ->toggleable(),
                //
                TextColumn::make('serial_number')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('model_number')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('manufacturer')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('lifetime_warranty')->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('warranty_expires')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('warranty_details')->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('purchase_time')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('purchase_from')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('purchase_price')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sold_time')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sold_to')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sold_price')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sold_notes')->searchable()->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('location.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TrashedFilter::make(),
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
                ReplicateAction::make()
                    ->excludeAttributes(['quantity', 'asset_id', 'ulid', 'created_at', 'updated_at', 'deleted_at'])
                    ->modal(false)->iconButton(),
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(ItemImporter::class)->options([
                        'team_id' => Filament::getTenant()?->id,
                    ]),
                ExportAction::make()->exporter(ItemExporter::class),
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
            // 'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): EloquentBuilder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): EloquentBuilder
    {

        return parent::getGlobalSearchEloquentQuery()->with(['location', 'tags']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'location.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        $record->load(['location', 'tags']);

        if ($record->location) {
            $details['Location'] = $record->location->name;
        }
        if ($record->tags) {
            $details['Labels'] = $record->tags->pluck('name')->join(', ');
        }

        $details['Asset ID'] = $record->asset_id;

        return $details;
    }
}
