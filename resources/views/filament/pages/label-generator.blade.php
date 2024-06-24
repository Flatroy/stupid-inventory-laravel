<x-filament-panels::page>
    <div class="no-print">
        <div class="">
            <p>
                Label Generator is a tool to help you print labels for your inventory. These are
                intended to be print-ahead labels so you can print many labels and have them ready to apply.
            </p>
            <p>
                As such, these labels work by printing a URL QR Code and Asset ID information on a label.
            </p>
            <h2>Tips</h2>
            <div class="px-4">
                <ul class="list-disc">
                    <li>
                        The defaults here are setup for the
                        <a href="https://www.avery.com/templates/5260">Avery 5260 label sheets</a>. If you're using a
                        different sheet, you'll need to adjust the settings to match your sheet.
                    </li>
                    <li>
                        When printing be sure to: <br>

                        <ol class="px-4 list-disc">
                            <li class="">Set the margins to 0 or None</li>
                            <li class="">Set the scaling to 100%</li>
                            <li class="">Disable double-sided printing</li>
                            <li class="">Print a test page before printing multiple pages</li>
                        </ol>
                    </li>
                </ul>
            </div>
        </div>


        <form wire:submit.debounce="generatePages" wire:change.debounce="generatePages">
            {{ $this->form }}

            <div class="my-4">
                <p>QR Code Link Example: {{ $this->baseURL }}/a/{asset_id}</p>
            </div>

            <x-filament::button type="submit" class="mt-4">
                Generate Pages
            </x-filament::button>


            <x-filament::button id="printButton" class="mt-4" onclick="printLabels()">
                Print Labels
            </x-filament::button>
        </form>


    </div>

    <div id="printableArea" class="mt-8">
        @foreach ($this->pages as $page)
            <section class="page-break">
                <div class="border-2 print:border-none"
                     style="
                        padding-top: {{ $page['page']['pt'] }}in;
                        padding-bottom: {{ $page['page']['pb'] }}in;
                        padding-left: {{ $page['page']['pl'] }}in;
                        padding-right: {{ $page['page']['pr'] }}in;
                        width: {{ $page['page']['width'] }}in;
                        height: {{ $page['page']['height'] }}in;
                    "
                >
                    @foreach ($page['rows'] as $row)
                        <div class="flex break-inside-avoid"
                             style="
                                column-gap: {{ $page['gapX'] }}in;
                                row-gap: {{ $page['gapY'] }}in;
                            "
                        >
                            @foreach ($row['items'] as $item)
                                <div
                                    class="flex {{ $this->bordered ? 'border-2 border-black' : 'border-2 border-transparent' }}"
                                    style="
                                        height: {{ $page['card']['height'] }}in;
                                        width: {{ $page['card']['width'] }}in;
                                    "
                                >
                                    <div class="flex items-center">
                                        <img src="{{ $item['url'] }}"
                                             style="
                                                width: {{ $page['card']['height'] * 0.9 }}in;
                                                height: {{ $page['card']['height'] * 0.9 }}in;
                                            "
                                        />
                                    </div>
                                    <div class="ml-2 flex flex-col justify-center">
                                        <div class="font-bold">{{ $item['assetID'] }}</div>
                                        <div class="text-xs font-light italic">{{ config('app.name') }}</div>
                                        <div>{{ $item['name'] }}</div>
                                        <div>{{ $item['location'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="no-print">
            This page is heavy inspired by the <a href="https://github.com/hay-kot/homebox/blob/main/frontend/pages/reports/label-generator.vue">Homebox Label Generator</a>.

        </div>
    </div>

    <script>
        function printLabels() {
            window.print();
        }
    </script>

    <style>
        
        @media print {
            .no-print {
                display: none;
            }

            .page-break {
                page-break-after: always;
            }

            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            #printableArea {
                width: 100%;
                height: 100%;
            }

            @page {
                size: auto;
                margin: 0mm;
                padding: 0mm;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .fi-topbar, .fi-sidebar, .fi-sidebar-open, .fi-header {
                display: none !important;
            }
        }
    </style>
</x-filament-panels::page>
