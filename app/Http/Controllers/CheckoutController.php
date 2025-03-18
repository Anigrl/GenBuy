<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Checkout;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //

    public function index(Request $request)
    {
        $product = Product::findorfail($request->product_id);

        $addresses = Address::where('user_id',Auth::id())->get();
        // dd($addresses);

        return view('checkout.index', ['product' => $product,'addresses'=>$addresses]);
    }

    public function  store(Request $request)
    {
        
        if($request->address=='on'){
            dd('hi');
        }
        dd($request->all());
        
        $user_id = auth()->user()->id;
        
        $validatedData = $request->validate([
            'address' =>['required'],
            'name' => ['required'],
            'mobile' => ['required', 'min:10'],
            'pincode' => ['required'],
            'locality' => ['required'],
            'address' => ['required'],
            'city' => ['required'],
            'district' => ['required'],
            'state' => ['required'],
        ]);
        
        // Inject user_id directly
        $validatedData['user_id'] = $user_id;
        
        Address::create($validatedData);
        
        
        // $order_id = $request->id;

        $order = Checkout::create([
            'user_id' => $user_id,
            'order_status' => 'pending',
        ]);

        $quantity = $request->quantity ?? 1;

        OrderItem::create([
            'checkout_id' => $order->id,
            'product_id' => $request->product_id,
            'quantity' => $quantity,
            'price' => ($request->price) * $quantity,
        ]);

        $product = Product::findOrFail($request->product_id);

        // Reduce stock after order placed
        $product->update([
            'stock' => $product->stock - $quantity
        ]);
        return redirect()->route('order.index')->with('success', 'Order placed successfully!');
    }

    public function cartorder(Request $request)
    {
        $user_id = Auth::id();
        $cart = Cart::where('user_id', $user_id)->where('is_active', true)->first();
        // dd($cart->id);
        $request->validate([
            'product_ids' => ['required', 'array'],
            'product_ids.*' => 'exists:products,id',

        ]);
        $totalPrice = 0;

        $order  = [
            'user_id' => $user_id,
            'order_status' => 'pending'
        ];

        $order = Checkout::create($order);

        foreach ($request->product_ids as $product_id) {

            $cartitem =   CartItem::where('cart_id', $cart->id)->where('product_id', $product_id)->first();



            $product = $cartitem->product;

            // Check stock before proceeding
            if ($product->stock < $cartitem->quantity) {
                return redirect()->back()->with('error', "Insufficient stock for product: {$product->name}");
            }

            $price = $cartitem->quantity * $cartitem->product->sale_price;
            $totalPrice += $price;
            // dd($cartitem->product->name);
            # code...

            $orderitem =   OrderItem::create([
                'checkout_id' => $order->id,
                'product_id' => $product_id,
                'quantity' => $cartitem->quantity,
                'price' =>  $price,
            ]);


            // Decrease product stock
            $product->decrement('stock', $cartitem->quantity);
        };

        $cart->delete();

        return redirect()->route('order.index')->with('success', 'order placed successfully');

        // dd($orderitem);
        // dd($product_ids);
    }
}
