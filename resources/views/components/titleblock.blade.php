@props(['fields' => [], 'cols' => 2, 'light' => false])
{{-- Drawing title block: label → value cells. A field whose label starts with "*" spans the full width. --}}
<dl {{ $attributes->class(['titleblock', 'light' => $light]) }} style="--cols: {{ $cols }}">
    @foreach ($fields as $label => $value)
        @continue($value === null || $value === '')
        <div @class(['wide' => str_starts_with($label, '*')])><dt>{{ ltrim($label, '*') }}</dt><dd>{{ $value }}</dd></div>
    @endforeach
</dl>
