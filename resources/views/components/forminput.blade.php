@props(['for', 'type' => 'text', 'name'])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-1 w-full']) }}>
    <label for="{{ $for }}" class="capitalize text-gray-700 text-sm font-semibold">
        {{ ucfirst($name) }}
    </label>
    <input 
        type="{{ $type }}" 
        id="{{ $for }}" 
        name="{{ $name }}" 
        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm"
    >
</div>
