<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function  index(Category $category)
    {
        $categories = Category::all();

        return view('auth.index',['category'=>$category ]);
    }

    public function store()
    {
        // dd(request()->all());
        $validated = request()->validate(
            [

                'number' => ['required', 'exists:users,number', 'min:10'],
                'password' => ['required']


            ]
        );

        if (!Auth::attempt($validated)) {
            return back()->withErrors([
                'number'=>'the provided credientials do not match',
            ]);
        }

        return redirect('/');
    }

    public function destroy()
    {

        Auth::logout();
        return redirect('/');
    }
}
