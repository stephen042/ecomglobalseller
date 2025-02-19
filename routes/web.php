<?php

use App\Models\User;
use App\Jobs\SendMail;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/readymade-7000-drop-shipping-suppliers-in-usa-download-link', function () {
    return view('home.readymade-7000-drop-shipping-suppliers-in-usa-download-link');
});

Route::get('/how-to-fix-amazon-seller-error-5665-without-brand-registry', function () {
    return view('home.how-to-fix-amazon-seller-error-5665-without-brand-registry');
});

Route::get('/how-to-launch-your-first-product-on-amazon-in-2021', function () {
    return view('home.how-to-launch-your-first-product-on-amazon-in-2021');
});

Route::get('/access', function () {
    return view('auth.login');
})->name('login');

Route::post('/access', [AuthController::class, 'authUser'])->name('post.login');

Route::get('/booking', function () {
    return view('auth.booking');
})->name('register');

// users Route
Route::prefix('users')->group(function () {
    Route::middleware('auth')->group(function () {

        // all user-auth route goes here
        Route::get('/', [UserController::class, 'index'])->name('dashboard');

        Route::get('/add-product', function () {
            $user_data = Auth::user();

            $user = User::findOrFail($user_data->id);

            $add_products = $user->addproducts()->orderByRaw('created_at desc')->get();

            return view('users.add-product',[
                "add_products" => $add_products,
            ]);
        })->name('add_product');

        Route::get('/affiliate-marketing', function () {
            return view('users.affiliate_marketing');
        })->name('affiliate_marketing');

        Route::get('/catalog', function () {
            $user_data = Auth::user();

            $user = User::findOrFail($user_data->id);

            $add_products = $user->addproducts()->where("status", 2)->orderByRaw('created_at desc')->Paginate(3);

            return view('users.catalog',[
                "catalogs" => $add_products,
            ]);
        })->name('catalog');


        Route::get('/giftcard', function () {

            if (!session()->has('amount')) {
                return redirect()->route('dashboard');
            }
            return view('users.giftcard');
        })->name('giftcard');

        Route::get('/transaction-history', function () {

            $user = Auth::user();
            $user = User::findOrFail($user->id);

            $deposits = $user->deposits()->orderByRaw('status = 1 desc, created_at desc')->get();

            return view('users.transaction-history', [
                'deposits' => $deposits,
            ]);
        })->name('transaction_history');

        Route::get('/withdrawal', function () {

            $user = Auth::user();
            $user = User::findOrFail($user->id);

            $withdrawals = $user->withdrawals()->orderByRaw('status = 1 desc, created_at desc')->get();

            return view('users.withdrawal', [
                'withdrawals' => $withdrawals,
            ]);
        })->name('withdrawal');

        Route::get('/pin',[UserController::class, 'pin'])->name('pin');
    });
});


//Admin Routes
Route::prefix('admin')->group(function () {
    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/',[AdminController::class, 'admin'])->name('admin_dashboard');
        Route::get('/edit-user/{user}',[AdminController::class, 'editUser'])->name('admin_editUser');
        Route::get('/edit-user/{user}/{addproduct}',[AdminController::class, 'viewProducts'])->name('admin_viewproducts');
        Route::get('/bookings',[AdminController::class, 'bookings'])->name('admin_bookings');
        Route::get('/bookings/{booking}',[AdminController::class, 'bookings_view'])->name('admin_bookings_view');
        Route::get('/admin-wallet',[AdminController::class, 'admin_wallet'])->name('admin_wallet');
    });
});
