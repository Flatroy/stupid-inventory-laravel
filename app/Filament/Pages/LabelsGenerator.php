<?php

namespace App\Filament\Pages;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Computed;

class LabelsGenerator extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.label-generator';

    public $bordered = false;

    public $baseURL = '';

    public $assetRange = 1;

    public $assetRangeMax = 90;

    public $gapY = 0.25;

    public $columns = 3;

    public $cardHeight = 1;

    public $cardWidth = 2.63;

    public $pageWidth = 8.5;

    public $pageHeight = 11;

    public $pageTopPadding = 0.52;

    public $pageBottomPadding = 0.42;

    public $pageLeftPadding = 0.25;

    public $pageRightPadding = 0.1;

    public function mount()
    {
        $this->baseURL = url('/');
        $this->form->fill();
        $this->generatePages(false);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // add select box with  US Letter, A4, A5 and other formats to the form with predefined sizes
                TextInput::make('assetRange')
                    ->label('Asset Start')
                    ->numeric()
                    ->required()
                    ->default($this->assetRange),
                TextInput::make('assetRangeMax')
                    ->label('Asset End')
                    ->numeric()
                    ->required()
                    ->default($this->assetRangeMax),
                TextInput::make('cardHeight')
                    ->label('Label Height (inches)')
                    ->numeric()
                    ->required()
                    ->default($this->cardHeight),
                TextInput::make('cardWidth')
                    ->label('Label Width (inches)')
                    ->numeric()
                    ->required()
                    ->default($this->cardWidth),
                TextInput::make('pageWidth')
                    ->label('Page Width (inches)')
                    ->numeric()
                    ->required()
                    ->default($this->pageWidth),
                TextInput::make('pageHeight')
                    ->label('Page Height (inches)')
                    ->numeric()
                    ->required()
                    ->default($this->pageHeight),
                TextInput::make('pageTopPadding')
                    ->label('Page Top Padding')
                    ->numeric()
                    ->required()
                    ->default($this->pageTopPadding),
                TextInput::make('pageBottomPadding')
                    ->label('Page Bottom Padding')
                    ->numeric()
                    ->required()
                    ->default($this->pageBottomPadding),
                TextInput::make('pageLeftPadding')
                    ->label('Page Left Padding')
                    ->numeric()
                    ->required()
                    ->default($this->pageLeftPadding),
                TextInput::make('pageRightPadding')
                    ->label('Page Right Padding')
                    ->numeric()
                    ->required()

                    ->default($this->pageRightPadding),
                TextInput::make('baseURL')
                    ->label('Base URL')
                    ->required()
                    ->default($this->baseURL),
                Checkbox::make('bordered')
                    ->label('Bordered Labels')
                    ->default($this->bordered),

            ])->columns(2);
    }

    public function generatePages($showNotification = true)
    {
        $this->validate();
        $this->init();
        if ($showNotification) {
            Notification::make()
                ->title('Success')
                ->body('Generated successfully')
                ->success()
                ->send();
        }
    }

    private function formatAssetID($aid): string
    {
        $aidStr = str_pad($aid, 6, '0', STR_PAD_LEFT);

        return substr($aidStr, 0, 3).'-'.substr($aidStr, 3);
    }

    private function getItem($n): array
    {
        $assetID = $this->formatAssetID($n);

        return [
            'url' => $this->getQRCodeUrl($assetID),
            'assetID' => $assetID,
            'name' => '_______________',
            'location' => '_______________',
        ];
    }

    private function calculateGridData()
    {
        $availablePageWidth = $this->pageWidth - $this->pageLeftPadding - $this->pageRightPadding;
        $availablePageHeight = $this->pageHeight - $this->pageTopPadding - $this->pageBottomPadding;

        if ($availablePageWidth < $this->cardWidth || $availablePageHeight < $this->cardHeight) {
            Notification::make()
                ->title('Error')
                ->body('Page size is too small for the card size')
                ->danger()
                ->send();

            return [
                'cols' => 0,
                'rows' => 0,
                'gapX' => 0,
                'gapY' => 0,
                'card' => ['width' => 0, 'height' => 0],
                'page' => [
                    'width' => 0, 'height' => 0,
                    'pt' => 0, 'pb' => 0, 'pl' => 0, 'pr' => 0,
                ],
            ];
        }

        $cols = max(1, floor($availablePageWidth / $this->cardWidth));
        $rows = max(1, floor($availablePageHeight / $this->cardHeight));
        $gapX = $cols > 1 ? ($availablePageWidth - $cols * $this->cardWidth) / ($cols - 1) : 0;
        $gapY = $rows > 1 ? ($availablePageHeight - $rows * $this->cardHeight) / ($rows - 1) : 0;
        return [
            'cols' => $cols,
            'rows' => $rows,
            'gapX' => $gapX,
            'gapY' => $gapY,
            'card' => ['width' => $this->cardWidth, 'height' => $this->cardHeight],
            'page' => [
                'width' => $this->pageWidth,
                'height' => $this->pageHeight,
                'pt' => $this->pageTopPadding,
                'pb' => $this->pageBottomPadding,
                'pl' => $this->pageLeftPadding,
                'pr' => $this->pageRightPadding,
            ],
        ];
    }

    private function init()
    {
        if ($this->assetRange > $this->assetRangeMax) {
            return;
        }
        $diff = $this->assetRangeMax - $this->assetRange;
        if ($diff > 999) {
            return;
        }
        $items = [];
        for ($i = $this->assetRange; $i <= $this->assetRangeMax; $i++) {
            $items[] = $this->getItem($i);
        }
        $this->calcPages($items);
    }

    private function calcPages($items)
    {
        $out = $this->calculateGridData();
        $pages = [];
        $perPage = $out['rows'] * $out['cols'];
        $itemsCopy = $items;
        $totalItems = count($itemsCopy);
        $itemsProcessed = 0;

        while ($itemsProcessed < $totalItems) {
            $page = [
                'rows' => [],
                'page' => $out['page'],
                'gapX' => $out['gapX'],
                'gapY' => $out['gapY'],
                'card' => $out['card'],
            ];

            for ($i = 0; $i < $perPage && $itemsProcessed < $totalItems; $i++) {
                $item = array_shift($itemsCopy);
                $itemsProcessed++;

                $rowIndex = floor($i / $out['cols']);
                if (! isset($page['rows'][$rowIndex])) {
                    $page['rows'][$rowIndex] = ['items' => []];
                }

                $page['rows'][$rowIndex]['items'][] = $item;
            }

            $pages[] = $page;
        }

        $this->pages = $pages;
    }

    private function getQRCodeUrl(string $assetID): string
    {
        $origin = rtrim($this->baseURL, '/');
        // TODO: maybe we need team_id here too?
        $data = "{$origin}/a/{$assetID}";

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);

        $svg = $writer->writeString($data);

        $svgBase64 = base64_encode($svg);

        return 'data:image/svg+xml;base64,'.$svgBase64;
    }

    #[Computed]
    public function pages()
    {
        return $this->pages ?? [];
    }
}
