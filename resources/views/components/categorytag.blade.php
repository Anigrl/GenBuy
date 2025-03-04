@props(['image','title','route'])

<a href="/products/{{$route}}" class="flex flex-col gap-2 justify-center items-center cursor-pointer">
    <div><img src="{{$image}}" alt="mobile" width="44px" class="bg-transparent"></div>
    <p class="capitalize font-roboto text-sm">{{$title}}</p>
</a>