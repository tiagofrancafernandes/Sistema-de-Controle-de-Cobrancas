@props([
    'view',
    'data' => null,
])

@php
    $data ??= [];
    $data = is_array($data) ? $data : [];
@endphp
<div>
    <x-custom-inline-blade
        :view="$view"
        :data="$data"
    />
</div>
