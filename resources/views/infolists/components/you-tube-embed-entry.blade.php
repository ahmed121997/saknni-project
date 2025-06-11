<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        <div class="mt-2">
            <iframe width="100%" height="400" src="{{ get_youtube_embed_url($getState()) }}" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</x-dynamic-component>
