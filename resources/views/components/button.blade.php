  

@props(['title', 'icon', 'href' => '#']) {{-- Default href to '#' if not provided --}}

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'text-white py-2 px-4 rounded-md shadow-md transition flex items-center gap-2']) }}>
    <i class="fas fa-{{ $icon }}"></i>
    {{ $title }}
</a>
