<x-layout>
    <x-nav></x-nav>

    @if (session('success'))
    <h2 class="bg-green-500 p-2 text-white">{{ session('success') }}</h2>
    @endif
    <section class="max-w-[1200px] mt-10 mx-auto p-4 bg-gray-200 flex gap-6">

        {{-- Sidebar Filter Section --}}
        <section class="p-4 w-[300px] bg-white flex flex-col gap-4 shadow-md rounded-md h-fit">
            <h2 class="text-2xl font-semibold text-gray-800/70 font-poppins mb-2">Filters</h2>

            {{-- Order Status --}}
            <div>
                <h3 class="text-gray-800 font-medium border-b border-black/20 pb-1">Order Status</h3>
                <div class="flex gap-2 items-center text-sm mt-2">
                    <input type="checkbox" id="pending">
                    <label for="pending" name="pending">Pending</label>
                </div>
                <div class="flex gap-2 items-center text-sm mt-2">
                    <input type="checkbox" id="completed">
                    <label for="completed" name="completed">Completed</label>
                </div>
            </div>

            {{-- Order By Time --}}
            <div>
                <h3 class="text-gray-800 font-medium border-b border-black/20 pb-1">Order By Time</h3>
                <div class="flex gap-2 items-center text-sm mt-2">
                    <input type="checkbox" id="prevmonth">
                    <label for="prevmonth">Last 30 Days</label>
                </div>
                <div class="flex gap-2 items-center text-sm mt-2">
                    <input type="checkbox" id="prevyear">
                    <label for="prevyear">2024</label>
                </div>
            </div>
        </section>

        {{-- Orders List Section --}}
        <section class="p-6 bg-white shadow-lg rounded-lg w-full max-w-4xl">
            {{-- Search Bar --}}
            <div class="flex gap-2 mb-6">
                <input type="text" name="search" id="searchbar"
                    class="border border-gray-300 px-4 py-2 flex-1 rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                <x-button :icon="''" title="Search Products" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                </x-button>
            </div>

            {{-- Orders List --}}
            <div class="flex flex-col gap-6" id="orderContainer">
                @foreach ($orders as $order)
                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    {{-- Order Header --}}
                    <div class="flex justify-between items-center border-b pb-2 mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">
                            Order #{{ $order->id }} -
                            <span class="text-blue-500">{{ ucfirst($order->order_status) }}</span>
                        </h3>
                        <span class="text-sm text-gray-500">Placed on: {{ $order->created_at->format('M d, Y') }}</span>
                    </div>

                    {{-- Order Items --}}
                    <div class="grid gap-4">
                        @foreach ($order->orderItems as $orderItem)
                        @if ($orderItem->product)
                        <a href="/products/{{$orderItem->product->category->name}}/{{$orderItem->product->name}}">

                            <div class="flex items-center gap-6 bg-white p-4 rounded-md shadow-sm">
                                {{-- Product Image --}}
                                <img src="{{ asset('storage/'.$orderItem->product->image) }}"
                                    alt="{{ $orderItem->product->name }}"
                                    class="w-24 h-24 object-cover rounded-md border">

                                {{-- Product Details --}}
                                <div class="flex-1">
                                    <h2 class="text-lg font-medium text-gray-800">{{ $orderItem->product->name }}</h2>
                                    <p class="text-sm text-gray-600">Quantity: <span class="font-semibold">{{
                                            $orderItem->quantity }}</span></p>
                                </div>

                                {{-- Price --}}
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-gray-700">${{ $orderItem->price }}</p>
                                </div>
                            </div>
                        </a>

                        @else
                        <p class="text-red-500">Product not found</p>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </section>
    <section class="my-4">

        {{$orders->links()}}
    </section>
</x-layout>

@vite([ 'resources/js/order.js'])