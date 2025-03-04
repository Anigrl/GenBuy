<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    //
    public function show( $category,  $product)
    {
        // Find category by name
        $category = Category::where('name', $category)->firstOrFail();

        // Find the correct product under this category
        $product = Product::where('name', $product)
            ->where('category_id', $category->id)
            ->firstOrFail();
        // dd($product->name);
        // $categories = Category::all();
        // dd($product->category->name);

        return view('products.show', ['category' => $category, 'product' => $product]);
    }

    public function create()
    {
        return view('products.create');
    }


    public function  store()
    {

        $validated = request()->validate([
            'category' => ['required', 'exists:categories,id'], // Ensure the category exists
            'product_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->where('category_id', request('category')) // Ensure unique per category
            ],
            'price' => ['required', 'numeric', 'min:1'], // Must be a number and at least 1
            'sale_price' => ['nullable', 'numeric', 'lte:price'], // Sale price must be less than or equal to price
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'], // Image validation (max 2MB),
            'description' => ['nullable'],
            'stock' => ['nullable', 'numeric']

        ]);

        if (request()->hasFile('image')) {
            $imagePath = request()->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product =   Product::create([
            'category_id' => $validated['category'],
            'name' => $validated['product_name'],
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'],
            'image' => $validated['image'],
            'stock' => $validated['stock'] ?? 0 // Default stock is 0 if not provided
        ]);

        $category = Category::findOrFail($validated['category']);


        // Redirect with the correct category name and product name
        // return redirect("/products/{$category->name}/{$product->name}");
        return redirect()->route('products.show', [
            'category' => $category->name,
            'product' => $product->name // Safer to use ID instead of name
        ]);


        dd($validated);
    }
}
