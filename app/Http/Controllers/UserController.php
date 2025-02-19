<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() {
        $user = Auth::user(); // Get the logged-in user

        $currentYear = Carbon::now()->year;
    
        // Query to calculate monthly sales for the current year
        $monthlySales = DB::table('add_products')
            ->select(
                DB::raw("DATE_FORMAT(updated_at, '%Y-%m') as month"),
                DB::raw("SUM(price * productQuantity) as total_sales")
            )
            ->where('user_id', $user->id) // Only consider the current user's products
            ->where('soldInStock', 2) // Only sold-out products
            ->where('status', 2) // Only accepted products
            ->whereYear('updated_at', $currentYear) // Filter by the current year
            ->groupBy(DB::raw("DATE_FORMAT(updated_at, '%Y-%m')"))
            ->get();
    
        // Initialize sales data for each month of the current year
        $salesData = array_fill(0, 12, 0); // [0, 0, 0, ..., 0] for January to December
    
        // Populate the sales data array
        foreach ($monthlySales as $sale) {
            $monthIndex = (int) Carbon::parse($sale->month)->format('m') - 1; // Convert month to index (0-11)
            $salesData[$monthIndex] = (float) $sale->total_sales;
        }
    
        // Pass the calculated sales data to the view
        return view('users.index', [
            'salesData' => $salesData,
            'countrySvg' => str_replace(' ', '', $user->country) // Removing whitespace for SVG mapping
        ]);
    }
       
    public function pin() {
        return view('users.pin');
    }
}
