<section class="p-4 bg-slate-200 flex justify-evenly gap-1 space-x-4 max-w-[1200px] mx-auto mt-4">
     
    @foreach ($categories as $category)
    <x-categorytag :title="$category->name" :image="$category->image" :route="$category->name">

    </x-categorytag>

    @endforeach


</section>