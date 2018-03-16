<div class="uk-form-row uk-form-row-{{ $name }}  {{ array_get($row, 'css_class_row') }}">
    <label for="form-contact-{{ $name }}" class="uk-form-label">{{ $row['title'] }}:</label>
    <select id="form-contact-{{ $name }}" name="{{ $name }}" class="{{ array_get($row, 'css_class') }}">
        @foreach($options as $option)
            <option @if(array_has($option, 'selected')) selected @endif value="{{ $option['value'] }}">{{ $option['title'] }}</option>
        @endforeach
    </select>
</div>