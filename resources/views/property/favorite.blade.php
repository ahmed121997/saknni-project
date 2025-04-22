@auth()
    <a href="#!" title="favorite">
        <i data="{{ $id }}"
            class="@if ($fav) fas @else far @endif fa-heart fa-lg mt-2 icon-love
            {{ app()->getLocale() == 'en' ? ' float-right mr-2' : ' float-left ml-2' }}">
        </i>
    </a>
@endauth
