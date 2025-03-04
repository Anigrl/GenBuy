<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('register.index');
    }

    public function store()
    {
        // dd(request()->all());

        $validated = request()->validate(
            [
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
                'number' => ['required', 'unique:users,number', 'min:10'],
                'password' => ['required', 'confirmed', 'min:5']


            ]
        );

        $user =  User::create($validated);
        Auth::login($user);

        return redirect('/');

    }
}
