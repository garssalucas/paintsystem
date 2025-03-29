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
    <div id="al" class="{{ $colorClass }} border-l-4 p-4 mb-4 rounded shadow-md flex justify-between items-center">
        <p>{{ $message }}</p>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('al');
        setTimeout(function () {
            if (alert) {
                alert.classList.add('hidden');
            }
        }, 4000);
    });
</script>