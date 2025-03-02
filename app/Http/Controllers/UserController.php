<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() {
        $user = Auth::user();
    
        // Get first sale date for the user
        $firstSale = DB::table('add_products')
            ->where('user_id', $user->id)
            ->where('soldInStock', 2)
            ->where('status', 2)
            ->orderBy('updated_at', 'asc')
            ->value('updated_at');
    
        $salesData = [];
        $weekLabels = [];
    
        if ($firstSale) {
            $firstSaleDate = Carbon::parse($firstSale)->startOfWeek();
            $currentDate = Carbon::now()->endOfWeek();
    
            // Fetch weekly sales data
            $weeklySales = DB::table('add_products')
                ->select(
                    DB::raw("YEARWEEK(updated_at, 1) as week"), // ISO week format
                    DB::raw("SUM(price * productQuantity) as total_sales")
                )
                ->where('user_id', $user->id)
                ->where('soldInStock', 2)
                ->where('status', 2)
                ->whereBetween('updated_at', [$firstSaleDate, $currentDate])
                ->groupBy('week')
                ->get();
    
                // Prepare chart data (limit to last 5 weeks dynamically)
                $weeklyData = collect($weeklySales)->map(function ($sale) {
                    if (!is_object($sale) || empty($sale->week)) {
                        return null; // Skip invalid data
                    }

                    $weekString = (string) $sale->week;
                    
                    if (strlen($weekString) < 6) {
                        return null; // Ensure correct format
                    }

                    $year = substr($weekString, 0, 4);
                    $weekNumber = substr($weekString, 4, 2);

                    return [
                        'week' => Carbon::now()->setISODate((int) $year, (int) $weekNumber)->startOfWeek()->format('M d'),
                        'sales' => (float) $sale->total_sales,
                    ];
                })->filter()->slice(-5); // Remove nulls and limit to last 5 weeks

    
            foreach ($weeklyData as $data) {
                $weekLabels[] = $data['week'];
                $salesData[] = $data['sales'];
            }
        }
    
        return view('users.index', [
            'salesData' => $salesData,
            'weekLabels' => $weekLabels,
            'countrySvg' => str_replace(' ', '', $user->country)
        ]);
    }
    
    
    
    
    
    public function pin() {
        return view('users.pin');
    }
}
