<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class="flex items-center space-x-3">
        @if ($image = $entry->getImageUrl() ?? null)
            <img src="{{ $image }}" alt="{{ $getRecord()->name }}" class="h-10 w-10 rounded-full object-cover me-1">
        @endif
        <span>{{ $getState() }}</span>
    </div>
</x-dynamic-component>
