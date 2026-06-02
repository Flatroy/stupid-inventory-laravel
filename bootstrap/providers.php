<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AppPanelProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\JetstreamServiceProvider;

return [
    AppServiceProvider::class,
    AppPanelProvider::class,
    FortifyServiceProvider::class,
    JetstreamServiceProvider::class,
];
