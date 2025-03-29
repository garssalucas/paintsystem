@props(['type' => 'info', 'message' => null])

@php
    $colors = [
        'success' => 'bg-green-100 border-green-500 text-green-700',
        'error' => 'bg-red-100 border-red-500 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-500 text-blue-700',
    ];

    $colorClass = $colors[$type] ?? $colors['info'];
@endphp

@if ($message)
<div class="{{ $colorClass }} border-l-4 p-4 mb-4 rounded shadow-md flex justify-between items-center">
    <p>{{ $message }}</p>
    <button class="absolute top-2 right-2 text-opacity-70 hover:text-opacity-100 {{ $colorClass }} rounded-full p-1"
        onclick="this.parentElement.style.display='none'">
        <x-lucide-x class="w-4 h-4" />
    </button>
</div>
@endif