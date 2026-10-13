@props(['type' => 'success'])

@php
$classes = match($type) {
    'success' => 'bg-emerald-50 border-emerald-300 text-emerald-800',
    'error' => 'bg-rose-50 border-rose-300 text-rose-800',
    'warning' => 'bg-amber-50 border-amber-300 text-amber-800',
    default => 'bg-blue-50 border-blue-300 text-blue-800',
};
$icon = match($type) {
    'success' => 'fa-circle-check',
    'error' => 'fa-circle-exclamation',
    'warning' => 'fa-triangle-exclamation',
    default => 'fa-circle-info',
};
@endphp

<div class="mb-6 p-4 rounded-lg border flex items-center justify-between {{ $classes }} shadow-sm transition">
    <div class="flex items-center gap-3">
        <i class="fa-solid {{ $icon }} text-lg"></i>
        <div class="text-sm font-medium">{{ $slot }}</div>
    </div>
</div>
