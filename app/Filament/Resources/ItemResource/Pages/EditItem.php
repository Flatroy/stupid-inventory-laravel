<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Infolists\Components\ImageEntry;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditItem extends EditRecord
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('ShowQrCode')
                ->button()
                ->label('QR Code')
                ->icon('heroicon-o-qr-code')
                ->modalHeading('QR Code:')
                ->action(function () {})
                ->modalSubmitAction(false)
                ->modalWidth(MaxWidth::Small)
                ->modalCancelAction(fn ($action) => $action->label('Close'))
                ->infolist([
                    ImageEntry::make('qr_code_url')->size(300)->label(''),
                ]),

            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
