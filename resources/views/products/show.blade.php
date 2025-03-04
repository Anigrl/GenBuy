<x-layout>
    <x-nav></x-nav>
    <x-secondCategory :categories="$categories"></x-secondCategory>

    <section class="max-w-[1200px] mt-8 mx-auto p-6   shadow-lg rounded-lg min-h-screen">
        @if (session('success'))
        <div class="bg-green-500 text-white px-4 py-2 rounded-md shadow-md mb-4">
            {{ session('success') }}
        </div>
        @endif
        <!-- Product Details Section -->
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Product Image -->
            <div class="flex-1 flex justify-center items-center">
                <img src="{{asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                    class="w-full max-w-md object-contain rounded-lg shadow-md border border-gray-200">
            </div>

            <!-- Product Information -->
            <div class="flex-1 bg-gray-100 p-6 rounded-lg shadow-md">
                <!-- Product Name -->
                <h2 class="text-3xl font-semibold text-gray-800 mb-4 border-b border-gray-300 pb-2 uppercase">
                    {{ $product->name }}
                </h2>

                <!-- Product Attributes -->
                {{-- <x-productAttributes :title="'Price'" :value="'₹' . $product->price"></x-productAttributes>
                <x-productAttributes :title="'Sale Price'"
                    :value="$product->sale_price ? '₹' . $product->sale_price : 'N/A'"></x-productAttributes>
                <x-productAttributes :title="'Stock'"
                    :value="$product->stock > 0 ? $product->stock . ' items available' : 'Out of Stock'">
                </x-productAttributes> --}}
                <h1 class="font-bold mt-2 text-lg">
                    <span class="text-gray-800 text-xl font-extrabold">₹{{ $product->sale_price }}</span>
                    <span class="text-gray-500 line-through ml-2">₹{{ $product->price }}</span>
                    <span class="text-green-600 font-semibold text-sm ml-2">
                        ({{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF)
                    </span>
                </h1>

                <!-- Product Description -->
                @if ($product->description)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Description:</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-8 flex gap-4">

                    {{--
                    <x-button title="Add to Cart" class="bg-blue-500 hover:bg-blue-700" :icon="'shopping-cart'"
                        :href="route('cart.add', ['product' => $product->id])" /> --}}
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit"
                            class="text-white bg-red-500 py-2 px-4 rounded-lg shadow-md transition flex items-center gap-2">
                            <i class="fas fa-shopping-cart"></i>Add to
                            Cart</button>
                    </form>

                    <form action="{{route('checkout.index' ,['product_id'=>$product->id])}}" method="GET">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <button type="submit" class="text-white bg-emerald-500 py-2 px-4 rounded-lg shadow-md transition flex items-center gap-2"><i class="fas fa-bolt"></i>Buy Now</button>
                    </form>
                    {{-- <x-button title="Buy Now" class="bg-emerald-500 hover:bg-emerald-700" :icon="'bolt'" /> --}}
                    <x-button title="Back to Products" class="bg-orange-500 hover:bg-orange-700" :icon="'bolt'"
                        :href="route('category.products', ['category' => $category->name])" />


                    {{-- <a href="/products/{{$category->name}}"
                        class="bg-gray-300 hover:bg-gray-400 text-black py-2 px-4 rounded-lg shadow-md transition">
                        Back to Products
                    </a> --}}
                </div>
            </div>
        </div>
    </section>
</x-layout>

<script>
    setTimeout(() => {
        document.querySelector('.bg-green-500')?.remove();
    }, 3000);
</script>