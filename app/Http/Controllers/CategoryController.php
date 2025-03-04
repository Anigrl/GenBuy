<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function show(Category $category){
        // dd($category->name);
        $categories = Category::all();
        return view('products.index' ,['category'=>$category]);
          
    }
}
