<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Checkout;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use PhpParser\Node\Stmt\TryCatch;

class CartController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        // Fetch the user's active cart
        $cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();

        if (!$cart) {
            // Return an empty array if no active cart is found
            return view('cart.index', ['cartItems' => []]);
        }

        // Fetch the cart items
        $cartItems = CartItem::where('cart_id', $cart->id)->get();

        return view('cart.index', ['cartItems' => $cartItems]);
    }


    public function create(Request $request)
    {
        //userid
        $user_id = auth()->user()->id;

        //productid
        $product_id = $request->product_id;

        $cart = Cart::where('user_id', $user_id)->where('is_active', true)->first();


        // if no active card exists create a new one
        if (!$cart) {
            $cart =  Cart::create([
                'user_id' => $user_id,
                'is_active' => true,
            ]);
        }

        // if()
        // agr vo product cart me exist krta ha to uske quantity ko bdao naki dubara add kro
        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $product_id)->first();


        if ($cartItem) {
            // If product exists, update the quantity
            $cartItem->increment('quantity');
        } else {
            // If product does not exist, add it to the cart
            $cart->items()->create([
                'product_id' => $product_id,
                'quantity' => 1, // Default to 1
            ]);
        }


        //add products to the cart


        return redirect()->back()->with('success', 'Product added to cart!');
    }

    //CartController.php
    public function total()
    {
        try {
            // Find the user's cart
            $cart = Cart::where('user_id', Auth::id())->first();

            if (!$cart) {
                return response()->json(['success' => false, 'error' => 'Cart not found.'], 404);
            }

            // Retrieve cart items related to the user's cart
            $cartItems = CartItem::where('cart_id', $cart->id)->with('product')->get();

            $total = $cartItems->sum(function ($item) {
                return $item->product->sale_price * $item->quantity;
            });

            return response()->json(['success' => true, 'total' => number_format($total, 2)]);
        } catch (\Exception $e) {
            \Log::error('Error in CartController@total: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'An error occurred.'], 500);
        }
    }

    // public function total()
    // {
    //     try {
    //         $cartItems = CartItem::where('user_id', Auth::id())->get();

    //         $total = $cartItems->sum(function ($item) {
    //             return $item->product->sale_price * $item->quantity;
    //         });

    //         return response()->json(['success' => true, 'total' => number_format($total, 2)]);
    //     } catch (\Exception $e) {
    //         // Log the error
    //         \Log::error('Error in CartController@total: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'error' => 'An error occurred.'], 500);
    //     }
    // }

    public function  destroy(Request $request)
    {
        // dd($request->cartitem_id);
        $cartitem_id = $request->cartitem_id;
        $cartiitem =  CartItem::where('id', $cartitem_id);
        if ($cartiitem) {
            $cartiitem->delete();
        }

        return redirect()->back()->with('success', 'Item removed from cart');
    }


    // public function reduce(Request $request)
    // {
    //     $cartItem = CartItem::where('product_id', $request->product_id)->first();

    //     if ($cartItem) {
    //         if ($cartItem->quantity > 1) {
    //             // Decrease quantity if more than 1
    //             $cartItem->update(['quantity' => $cartItem->quantity - 1]);
    //         } else {
    //             // Remove item if quantity is 1
    //             $cartItem->delete();
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Cart updated!');
    // }

    public function updateQuantity(Request $request)
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();

        if (!$cart) return response()->json(['success' => false, 'message' => 'Cart not found'], 404);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$cartItem) return response()->json(['success' => false, 'message' => 'Product not in cart'], 404);

        // Determine action: Increase or Decrease
        if ($request->action === 'increase') {
            $cartItem->increment('quantity');
            return response()->json(['success' => true, 'message' => 'Cart updated', 'quantity' => $cartItem->quantity]);
        } elseif ($request->action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
                return response()->json(['success' => true, 'message' => 'Cart updated', 'quantity' => $cartItem->quantity]);
            } else {
                $cartItem->delete();
                return response()->json(['success' => true, 'message' => 'Cart updated', 'quantity' => 0]); // Send quantity 0 after deletion
            }
        }
    }
}
