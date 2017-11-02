<div class="uk-form-row uk-form-row-{{ $name }} {{ array_get($row, 'css_class_row') }}">
    <label for="form-contact-{{ $name }}" class="uk-form-label">{{ $row['title'] }}:</label>
    <input type="{{ $row['type'] }}" id="form-contact-{{ $name }}" name="{{ $name }}" class="{{ array_get($row, 'css_class') }}">
</div>