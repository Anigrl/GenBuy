<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Models\Category;
use App\Models\Checkout;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//request for getting category 
Route::get('/getcategory', function () {
    $category = Category::all();
    return response()->json($category, 200);
});

Route::get('/', function () {
    $category = Category::all();
    return view('welcome', ['categories' => $category]);
});

//register
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

//login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'store']);

Route::delete('/logout', [AuthController::class, 'destroy']);

//products

Route::get('/products/{category}', [CategoryController::class, 'show'])->name('category.products');

Route::get('/products/{category}/{product}', [ProductController::class, 'show'])->name('products.show');

//admin dashboard for uploadin updateing products
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/product/create', [ProductController::class, 'create'])->middleware('auth');
Route::post('/product', [ProductController::class, 'store'])->middleware('auth');

//atttocart

Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');

Route::post('/cart/add', [CartController::class, 'create'])->name('cart.add')->middleware('auth');
Route::post('/cart/reduce', [CartController::class, 'reduce'])->name('cart.reduce');

Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');

//routes/web.php
Route::get('/cart/total', [CartController::class, 'total'])->name('cart.total');

Route::delete('/cart/delete', [CartController::class, 'destroy'])->name('cart.delete')->middleware('auth');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');

Route::get('/checkout/cart',[CheckoutController::class,'cartorder'])->name('checkout.cartorder')->middleware('auth');

Route::post('/checkout/address', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');

Route::get('/order', [OrderController::class, 'index'])->name('order.index')->middleware('auth');

//filters

Route::get('/search', function (Request $request) {

    $orders = Checkout::where('user_id', Auth::id());

    // Status Filters
    if ($request->has('status')) {
        $statusFilters = explode(',', $request->query('status'));
        $orders->whereIn('order_status', $statusFilters);
    }

    // Date Filters
    if ($request->has('startDate') && $request->has('endDate')) {
        $startDate = Carbon::parse($request->query('startDate'))->startOfDay();
        $endDate = Carbon::parse($request->query('endDate'))->endOfDay();
        $orders->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Search Term
    if ($request->has('term')) {
        $term = $request->query('term');
        $orders->whereHas('orderItems.product', function ($query) use ($term) {
            $query->where('name', 'LIKE', "%{$term}%"); // Use LIKE for partial matches
        });
    } 

    $results = $orders->with('orderItems.product')->latest()->get();
    return response()->json($results, 200);
});
