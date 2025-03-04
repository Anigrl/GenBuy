<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //

    public function index()
    {

        $orders = Checkout::where('user_id', Auth::id())
            ->with('orderItems.product') // Load related orderItems & products
            ->latest()->paginate(5);
        // dd($orders[0]);
        return view('order.index', ['orders' => $orders]);
    }
}
