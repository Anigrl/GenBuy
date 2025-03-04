<x-layout>
    <x-nav></x-nav>

    <h2 class="font-semibold mx-8 uppercase text-3xl border-b border-b-black/30 text-gray-800 mt-10">Upload A Product</h2>

    <section class="my-6 bg-white shadow-lg rounded-lg p-6 max-w-lg mx-auto">
        <form action="/product" method="POST" class="grid gap-4" enctype="multipart/form-data">
            @csrf

            <!-- Category Dropdown -->
            <div class="flex flex-col">
                <label for="category" class="font-medium text-gray-700">Select Category</label>
                <select name="category" id="category"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select a category</option>
                </select>
            </div>
            @error('category')
            <p class="text-red-400">{{$message}}</p>
                
            @enderror

            <!-- Product Name -->
            <div class="flex flex-col">
                <label for="product_name" class="font-medium text-gray-700">Product Name</label>
                <input type="text" id="product_name" name="product_name" placeholder="Enter product name"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" :value="old('product_name')">
            </div>
            @error('product_name')
            <p class="text-red-400">{{$message}}</p>
                
            @enderror

            <!-- Price -->
            <div class="flex flex-col">
                <label for="price" class="font-medium text-gray-700">Price</label>
                <input type="text" id="price" name="price" placeholder="Enter price"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" :value="old('price')">
            </div>
            @error('price')
            <p class="text-red-400">{{$message}}</p>
                
            @enderror

            <!-- Sale Price -->
            <div class="flex flex-col">
                <label for="sale_price" class="font-medium text-gray-700">Sale Price (Optional)</label>
                <input type="text" id="sale_price" name="sale_price" placeholder="Enter sale price"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" :value="old('sale_price')">
            </div>
             @error('sale_price')
            <p class="text-red-400">{{$message}}</p>
                
            @enderror

            <!-- Stock Quantity -->
            <div class="flex flex-col">
                <label for="stock" class="font-medium text-gray-700">Stock Quantity</label>
                <input type="number" id="stock" name="stock" min="1" placeholder="Enter quantity"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            @error('stock')
            <p class="text-red-400">{{$message}}</p>
                
            @enderror

            <div class="flex flex-col">
                <label for="image" class="font-medium text-gray-700">Choose Image</label>
                <input type="file" id="image" name="image" min="1"  
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" :value="old('image')">
            </div>
            @error('image')
            <p class="text-red-400">{{$message}}</p>
                
            @enderror

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md shadow-md transition-all duration-300">
                Upload Product
            </button>
        </form>
    </section>
</x-layout>




@vite(['resources/js/getcategory.js'])