<section class="p-2 bg-slate-200 flex justify-evenly gap-1 space-x-4 max-w-[1200px] mx-auto ">
     @foreach ($categories as $category)
         
     <x-secondCategorytag :title="$category->name" :route="$category->name">
 
     </x-secondCategorytag>
     @endforeach
 
</section>