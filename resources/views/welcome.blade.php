 <x-layout>
    <x-nav/>
    <x-categories :categories="$categories"></x-categories>
    <x-corousal></x-corousal>
 </x-layout>

 @push('scripts')
    @vite(['resources/js/carousel.js'])
@endpush