<x-layout>
    <x-nav></x-nav>
    {{-- --}}

    <section class="max-w-[1000px] flex gap-6">
        @if (session('success'))
            <h2 class="bg-green-500 p-2 text-white">{{session('success')}}</h2>
            
        @endif
        <!-- Left Side (Scrollable Content) -->
        <section class="flex-1 max-w-[700px] mt-4 p-4 grid gap-10 overflow-auto">
            <div class="p-6 bg-white shadow-md rounded-sm flex flex-col">
                <div class="flex justify-between items-center">
                    <h2 class="text-gray-800 font-bold text-2xl">Login</h2>
                    @auth
                    <i class="fa-solid fa-check text-2xl"></i>
                    @endauth
                    @guest
                    <a href="/login" class="flex items-center gap-2" title="get help">
                        <i class="fa-solid fa-sign-in-alt"></i>
                        <span class="text-sm font-semibold">Login</span>
                    </a>
                    @endguest
                </div>
                @auth
                <p class="text-lg mt-2 font-light text-black/60">{{auth()->user()->number}}</p>
                @endauth
            </div>
    
            <div class="flex flex-col gap-4 p-6 bg-white shadow-lg rounded-sm">
                <h2 class="text-gray-800 font-bold text-2xl">Shipping Address</h2>
                <form action="{{route('checkout.store')}}" method="POST" class="flex flex-col max-w-[800px] gap-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="price" value="{{$product->sale_price}}">
                    <div class="flex gap-4">
                        <x-forminput for="name" name="name"></x-forminput>
                        <x-forminput for="mobile" name="mobile" type="number"></x-forminput>
                    </div>
    
                    <div class="flex gap-4">
                        <x-forminput for="pincode" name="pincode" type="number"></x-forminput>
                        <x-forminput for="locality" name="locality"></x-forminput>
                    </div>
    
                    <x-forminput for="address" name="address"></x-forminput>
    
                    <div class="flex gap-4">
                        <x-forminput for="city" name="city"></x-forminput>
                        <x-forminput for="state" name="state"></x-forminput>
                    </div>
    
                    <button type="submit" name="submit"
                        class="bg-orange-600 w-1/3 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-sm shadow-md transition-all">
                        Proceed to Checkout
                    </button>
                </form>
            </div>
        </section>
    
        <!-- Right Side (Fixed Price Details) -->
        <section class="mt-4 p-6 bg-white shadow-md rounded-sm w-[350px] fixed right-10 top-24">
            <h2 class="text-gray-800 font-bold border-b pb-2 border-gray-300 uppercase tracking-wide">
                Price Details
            </h2>
            <div class="flex flex-col gap-4 mt-4 text-gray-700">
                <!-- Price Breakdown -->
                <div class="flex justify-between text-lg border-b pb-3 border-gray-300">
                    <span>Price (1 item):</span>
                    <span class="font-semibold">₹{{ number_format($product->sale_price, 2) }}</span>
                </div>
    
                <!-- Total Amount -->
                <div class="flex justify-between text-xl font-bold text-black">
                    <span>Total Payable:</span>
                    <span class="text-green-600">₹{{ number_format($product->sale_price, 2) }}</span>
                </div>
            </div>
        </section>
    </section>
    


</x-layout>