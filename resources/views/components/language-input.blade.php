<div class="col-12 mb-1 d-flex align-items-center">
    <label for="{{ $id }}En" class="form-label mb-0 mx-2">{{ $label }}</label>
    <div id="languageSwitcher-{{ $id }}" class="btn-group ms-3" role="group">
        @foreach(config('app.locales') as $key => $value)
            <button type="button" class="btn btn-sm btn-outline-primary {{ $key === 'en' ? 'active' : '' }}" data-lang="{{ $key }}">{{ strtoupper($key) }}</button>
        @endforeach
    </div>
</div>
<div class="language-input flex-grow-1 col-12 mt-0 mb-3" id="languageInputs-{{ $id }}">
    @foreach(config('app.locales') as $key => $value)
    <div data-lang="{{ $key }}" class="{{ $key === 'en' ? '' : 'd-none' }}">
        <input type="text" class="form-control" id="{{ $id }}_{{ $key }}" name="{{ $name }}[{{ $key }}]" placeholder="{{ $value }}" required>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const switcher = document.querySelectorAll('#languageSwitcher-{{ $id }} .btn');
        const inputsContainer = document.querySelector('#languageInputs-{{ $id }}');

        if (switcher.length > 0 && inputsContainer) {
            switcher.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove 'active' class from all buttons
                    switcher.forEach(btn => btn.classList.remove('active'));
                    // Add 'active' class to the clicked button
                    button.classList.add('active');

                    const selectedLang = button.getAttribute('data-lang');
                    const inputs = inputsContainer.querySelectorAll('div');

                    // Toggle visibility of input fields based on selected language
                    inputs.forEach(input => {
                        const isVisible = input.getAttribute('data-lang') === selectedLang;
                        input.classList.toggle('d-none', !isVisible);
                    });
                });
            });
        }
    });
</script>
@endpush
