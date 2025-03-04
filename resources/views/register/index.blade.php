<x-layout>
    <x-nav></x-nav>
    <x-secondCategory>

    </x-secondCategory>
    <section class="mt-4 bg-blue-500 min-h-[400px] max-w-[1000px] mx-auto flex justify-around mb-8">
        <div class="pt-10 px-6 text-5xl flex-1 mb-4">
            <h2 class="text-5xl text-white font-poppins">Register</h2>
            <p class="mt-10 text-lg text-white/70">
                Here are you finding something for you
            </p>
        </div>
        <div class="flex-1 bg-blue-100">

            <form action="/register" method="POST" class="  p-4 space-y-2">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="number">Enter Your Mobile Number</label>
                    <input type="number" id="number" name="number"
                        class="px-4 py-2 bg-slate-100 border-black/15 border">
                </div>
                @error('number')
                <p class="text-red-500">{{$message}}</p>
                    
                @enderror
                <div class="flex flex-col gap-2">
                    <label for="name">Enter Your Name</label>
                    <input type="text" id="name" name="name"
                        class="px-4 py-2 bg-slate-100 border-black/15 border">
                </div>
                @error('name')
                <p class="text-red-500">{{$message}}</p>
                    
                @enderror
                <div class="flex flex-col gap-2">
                    <label for="email">Enter Your Email</label>
                    <input type="email" id="email" name="email"
                        class="px-4 py-2 bg-slate-100 border-black/15 border">
                </div>
                @error('email')
                <p class="text-red-500">{{$message}}</p>
                    
                @enderror
                <div class="flex flex-col gap-2">
                    <label for="password">Enter Password</label>
                    <input type="password" id="password" name="password"
                        class="px-4 py-2 bg-slate-100 border-black/15 border">
                </div>
                @error('password')
                <p class="text-red-500">{{$message}}</p>
                    
                @enderror
                <div class="flex flex-col gap-2">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="px-4 py-2 bg-slate-100 border-black/15 border">
                </div>
                 

                <div>
                    <button type="submit" class="px-4 py-2 bg-yellow-300 text-black shadow-sm rounded-sm mt-4">
                        Register
                    </button>
                </div>

            </form>

            <div class="p-4 underline text-blue-600">
                <a href="/login">Already a Member? Login</a>
            </div>
        </div>


    </section>
</x-layout>