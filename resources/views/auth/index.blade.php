<x-layout>
    <x-nav></x-nav>
    <x-secondCategory  :categories="$categories">

    </x-secondCategory>
    <section class="mt-4 bg-blue-500 h-[400px] max-w-[1000px] mx-auto flex justify-around mb-8">
        <div class="pt-10 px-6 text-5xl flex-1 mb-4">
            <h2 class="text-5xl text-white font-poppins">Login</h2>
            <p class="mt-10 text-lg text-white/70">
                Here are you finding something for you
            </p>
        </div>
        <div class="flex-1 bg-blue-100">

            <form action="/login" method="POST" class="  p-4">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="number">Enter Your Mobile Number</label>
                    <input type="number" id="number" name="number"
                        class="px-4 py-2 bg-slate-100 border-black/15 border" :value="old('number')">
                </div>
                @error('number')
                <p class="text-red-400">{{$message}}</p>
                    
                @enderror
                <div class="flex flex-col gap-2">
                    <label for="password">Enter Password</label>
                    <input type="password" id="password" name="password"
                        class="px-4 py-2 bg-slate-100 border-black/15 border">
                </div>

                <div>
                    <button type="submit" class="px-4 py-2 bg-yellow-300 text-black shadow-sm rounded-sm mt-4">
                        Login
                    </button>
                </div>

            </form>

            <div class="p-4 underline text-blue-600">
                <a href="/register">New to GenBUY, Create a Account</a>
            </div>
        </div>


    </section>
</x-layout>