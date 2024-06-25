<a href="{{ \App\Filament\Resources\TagResource::getUrl('view', ['record' => $getRecord()]) }}"
   class="flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-700 hover:bg-primary-200 transition-colors duration-200 w-full h-full bg-amber-300">
    <x-filament::icon
        icon="heroicon-m-tag"
        class=" w-5 h-5 text-primary-600 dark:text-primary-400"
    />
    <span class="px-2 inline-flex">
        {{ $getRecord()->name }} {{ $getRecord()->items_count ? '('.$getRecord()->items_count.')': '' }}
    </span>
</a>
