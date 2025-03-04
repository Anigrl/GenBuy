<nav
    class="flex justify-between container max-w-[1200px]   items-center mx-auto border-b bg-blue-600/80 border-b-black/40 px-6 py-4 font-poppins">
    <a href="/">
        <div class="text-3xl text-white">
            Gen<span class="text-yellow-300">Buy</span>
        </div>
    </a>
    <div class="hidden sm:flex gap-4 text-white font-light gap-10  justify-between">

        <!-- Admin -->
        
        <!-- Help -->
        @guest

        <a href="/login" class="flex items-center gap-2" title="get help">
            <i class="fa-solid fa-sign-in-alt"></i>

            <span class="text-sm font-semibold">Login</span>

            {{-- Help --}}
        </a>
        @endguest
        @auth
        <a href="#" class="flex items-center text-white font-bold font-poppins">
            {{-- {{auth()->user()->name}} --}}
            My Account
        </a>
        <a href="/dashboard" class="flex items-center gap-2" title="get help">
            <i class="fa-solid fa-file"></i>
            <span class="text-sm font-semibold">Dashboard</span>
            {{-- Help --}}
        </a>
        <a href="/cart"
            class="flex items-center gap-2 relative px-4 py-2   text-white rounded-lg  ">
            <div class="relative">
                <i class="fa-solid fa-shopping-cart text-xl"></i>

                <!-- Cart Count Badge -->
                @if($cartcount > 0)
                <span
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-md">
                    {{$cartcount}}
                </span>
                @endif
            </div>

            <span class="text-sm font-semibold">Cart</span>
        </a>

        <form action="/logout" method="POST" class="flex items-center gap-2 text-white font-bold font-poppins">
            @csrf
            @method('DELETE')
            <i class="fa-solid fa-sign-out-alt"></i>
            <button type="submit" class="text-sm font-semibold">LogOut</button>
        </form>
        @endauth

        <button class="px-3 py-1 rounded-md bg-yellow-300 text-black/80 transition-all text-sm font-semibold duration-300 hover:bg-white   cursor-pointer">Explore</button>
    </div>
</nav>