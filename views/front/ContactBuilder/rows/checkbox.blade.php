<div class="uk-form-row uk-form-row-{{ $name }} {{ array_get($row, 'css_class_row') }}">
    <label for="form-contact-{{ $name }}" class="uk-form-label">
        <input type="checkbox" id="form-contact-{{ $name }}" name="{{ $name }}">
        {{ $row['title'] }}
    </label>
</div>