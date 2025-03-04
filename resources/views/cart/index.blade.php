<x-layout>
    <x-nav></x-nav>
    <x-secondCategory :categories="$categories">
    </x-secondCategory>
    <section class="flex gap-2 max-w-[1200px] mx-auto">

        @empty($cartItems)
        <section
            class="font-poppins mx-auto flex-1 max-w-[600px] p-4 flex justify-center items-center flex-col min-h-[300px]  bg-white shadow-md mt-4">
            <h3 class="text-center text-xl ">Your Cart Is Empty</h3>
            <p>Add Items To it now</p>

            <a href="/" class="px-3 py-1 bg-blue-500 rounded-sm shadow-sm text-white cursor-pointer">Shop Now</a>
        </section>

        @endempty
        @empty(!$cartItems)
        <section class=" mt-4 flex-1 p-4  grid gap-10  ">




            @if (session('success'))
            <div class="bg-green-500 h-12 text-white px-4 py-2 rounded-md shadow-md mb-4">
                {{ session('success') }}
            </div>
            @endif

            @forelse($cartItems as $cartitem)


            <div class="p-4 shadow-md rounded-md bg-slate-100 flex gap-2 ">
                <div class="flex justify-center items-center">
                    <img src="{{asset('storage/'.$cartitem->product->image)}}" alt="{{$cartitem->product->name}}"
                        class="w-32 object-contain rounded-lg shadow-md">
                </div>
                <div class="flex flex-col justify-between gap-2  ml-10">
                    <div>

                        <h2 class="text-lg font-medium capitalize">{{$cartitem->product->name}}</h2>
                        <div class="flex items-center gap-4">

                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <button data-action="increase" data-product-id="{{ $cartitem->product->id }}"
                                class="quantity-button text-xl font-bold bg-blue-500 hover:bg-blue-700 rounded-full h-8 w-8 flex items-center justify-center text-white transition-all shadow-md">
                                +
                            </button>

                            <!-- Quantity Display -->
                            <p id="quantityshow"
                                class="text-xl font-semibold px-2 py-1 bg-gray-100 border border-gray-300 rounded-md text-center w-10">
                                {{$cartitem->quantity}}
                            </p>


                            <!-- Decrease Quantity -->
                            <button data-action="decrease" data-product-id="{{ $cartitem->product->id }}"
                                class=" quantity-button text-xl font-bold bg-red-500 hover:bg-red-700 rounded-full h-8 w-8 flex items-center justify-center text-white transition-all shadow-md">
                                -
                            </button>

                        </div>

                    </div>
                    <div class="mt-auto ">

                        <form action="{{route('cart.delete')}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="cartitem_id" value="{{$cartitem->id}}">
                            <button type="submit" class="bg-red-500  px-2 py-1 rounded-sm text-white">Remove</button>
                        </form>
                    </div>
                </div>

                {{-- {{$cartitem->product}} --}}
            </div>


            {{-- <p>{{ $cartitem }}</p> --}}
            @empty
            <p>No items available.</p>
            @endforelse

            <div class="bg-white shadow-md p-4 flex">
                <form action="{{ route('checkout.cartorder') }}" method="GET">
                    @csrf
                    @foreach($cartItems as $cartItem)
                    <input type="hidden" name="product_ids[]" value="{{ $cartItem->product->id }}">
                    @endforeach

                    
                    @if ($cartItems->some(function ($item) { return $item->quantity > 0; }))
                    <button type="submit"
                        class="text-white bg-emerald-500 py-2 px-4 rounded-lg shadow-md transition flex items-center gap-2">
                        <i class="fas fa-bolt"></i>Place Order
                    </button>
                    @endif
                </form>
            </div>

        </section>

        <!-- Right Side (Fixed Price Details) -->
        <section class="mt-4 p-4 bg-slate-100 shadow-md rounded-sm w-[350px] ">
            <h2 class="text-gray-800 font-bold border-b pb-2 border-gray-300 uppercase tracking-wide">
                Price Details
            </h2>
            <div class="flex flex-col gap-4 mt-4 text-gray-700">
                <!-- Price Breakdown -->
                <div class="flex justify-between text-lg border-b pb-3 border-gray-300">
                    <span>Price ({{count($cartItems)}} item):</span>
                    <span class="font-semibold quantity">₹{{ number_format( $cartItems->sum(function($item){ return
                        $item->product->sale_price * $item->quantity; }), 2) }}</span>
                </div>

                <div class="flex justify-between text-xl font-bold text-black">
                    <span>Total Payable:</span>
                    <span class="text-green-600 quantity">₹{{ number_format($cartItems->sum(function($item){ return
                        $item->product->sale_price * $item->quantity; }), 2) }}</span>
                </div>
            </div>


        </section>
        @endempty

    </section>


</x-layout>

<script>
    setTimeout(() => {
        document.querySelector('.bg-green-500')?.remove();
    }, 3000);

    let quantityDisplay = document.querySelector('#quantityshow');

    document.querySelectorAll('.quantity-button').forEach(button => {
        button.addEventListener('click',function(){
            let action = this.getAttribute("data-action");
            let productId = this.getAttribute("data-product-id");
            // console.log(action);

            fetch("/cart/update", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ action, product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                 
                console.log(data)
                quantityDisplay.textContent = data.quantity; // Update quantity display
                updateTotalPrice(); // Update total price.
            } else {
                alert('Failed to update quantity.'); // User-friendly error
            }
            
        })
        .catch(error => console.error("Error:", error));
    });
    
});

    function updateTotalPrice() {
    fetch('/cart/total')
    .then(response => response.json())
    .then(data => {
        if(data.success){
             
            document.querySelectorAll('.quantity').forEach(quantity=>{

                quantity.textContent= '₹' + data.total;
            })

        }
    })
    .catch(error => console.error("Error:", error));
}
updateTotalPrice();
 
</script>