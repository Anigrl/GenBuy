<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
                // Share 'categories' globally across all views
                view()->share('categories', Category::all());

                //cartcount
                // view()->share('cartcount',count(CartItem::where('cart_id',Cart::where('user_id',Auth::user()->id))));

                view()->composer('*', function ($view) {
                    if (Auth::check()) {
                        $user = Auth::user();
                        
                        // Fetch the active cart for the user
                        $cart = Cart::where('user_id', $user->id)->where('is_active', true)->first();
            
                        // Count items in the cart (if exists)
                        $cartCount = $cart ? CartItem::where('cart_id', $cart->id)->count() : 0;
                    } else {
                        $cartCount = 0; // If no user is logged in, cart count should be 0
                    }
            
                    $view->with('cartcount', $cartCount);
                });
            
    }
}
