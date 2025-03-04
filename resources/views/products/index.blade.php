<x-layout>
    <x-nav></x-nav>
    <x-secondCategory :categories="$categories">

    </x-secondCategory>
    <section class="max-w-[1200px] mt-4 mx-auto p-4 min-h-screen">
        <h2 class="uppercase font-bold text-4xl font-poppins border-b-black/15 border-b">
            {{$category->name}}
        </h2>
        <div class="mt-4">
            {{-- <h2 class="uppercase font-semibold text-2xl text-black/50 border-b-black/15 border-b">Products</h2>
            --}}
            <div class="grid  sm:grid-cols-3 lg:grid-cols-4 p-4 gap-6">
                @foreach ($category->products as $product)
                <a href="/products/{{$category->name}}/{{$product->name}}">

                    <div class="bg-gray-200/40 text-black/80 shadow-md rounded-md px-4 py-2">
                        <div class="flex items-center justify-center">
                            {{-- <img src="{{$product->image}}" alt="" class="w-full object-contain"> --}}
                            <img src="{{asset('storage/' . $product->image) }}" alt="" class="w-full object-contain">
                            {{-- "{{ asset('storage/' . $product->image) }} --}}
                        </div>
                        <h2 class="uppercase text-gray-900 font-[500] mt-2   mb-2">
                            {{$product->name}}
                        </h2>
                        <h1 class="font-bold mt-2 text-lg">
                            <span class="text-gray-800 text-xl font-extrabold">₹{{ $product->sale_price }}</span>
                            <span class="text-gray-500 line-through ml-2">₹{{ $product->price }}</span>
                            <span class="text-green-600 font-semibold text-sm ml-2">
                                ({{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF)
                            </span>
                        </h1>
                        {{-- <h1 class="font-bold mt-2">{{$product->sale_price}} <span class=""> {{$product->price}} </span></h1> --}}

                        {{-- <x-productAttributes :title="'Price'" :value="$product->price"></x-productAttributes>
                        <x-productAttributes :title="'Sale Price'" :value="$product->sale_price"></x-productAttributes>
                        <x-productAttributes :title="'Stock'" :value="$product->stock"></x-productAttributes> --}}

                    </div>
                </a>


                @endforeach
            </div>
        </div>
    </section>
</x-layout>