<section class="mt-4 bg-gray-300 mx-auto max-w-[1200px] max-h-64 overflow-hidden relative">
    <div id="carousel" class="flex transition-transform duration-500 ease-in-out">
        <div class="w-full shrink-0">
            <img src="{{asset('images/shopping.jpg')}}" alt="" class="h-64 object-cover block w-full">
        </div>
        <div class="w-full shrink-0">
            <img src="{{asset('images/shopping.jpg')}}" alt="" class="h-64 object-cover block w-full">
        </div>
        <div class="w-full shrink-0">
            <img src="{{asset('images/shopping.jpg')}}" alt="" class="h-64 object-cover block w-full">
        </div>
    </div>

    <button class="absolute top-1/2 left-0 transform -translate-y-1/2 py-1 px-2 bg-slate-300/80 text-3xl" id="leftButton">
        <i class="fas fa-arrow-left"></i>
    </button>
    <button class="absolute top-1/2 right-0 transform -translate-y-1/2 py-1 px-2 bg-slate-300/80 text-3xl" id="rightButton">
        <i class="fas fa-arrow-right"></i>
    </button>
</section>

 
