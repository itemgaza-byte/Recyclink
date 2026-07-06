<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerReportController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = auth()->id();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Base query for seller's completed orders
        $orderQuery = \App\Models\Order::query()
            ->where('seller_id', $sellerId)
            ->where('order_status', \App\Models\Order::STATUS_COMPLETED);

        if ($startDate) {
            $orderQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $orderQuery->whereDate('created_at', '<=', $endDate);
        }

        // Metrics
        $totalSales = $orderQuery->count();
        $totalRevenue = $orderQuery->sum('subtotal'); // Seller revenue uses subtotal or total minus fees

        // Chart Data (Sales over time)
        $chartQuery = clone $orderQuery;
        $chartDataRaw = $chartQuery->select(\Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'), \Illuminate\Support\Facades\DB::raw('SUM(subtotal) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $chartData = [
            'labels' => $chartDataRaw->pluck('date')->toArray(),
            'data' => $chartDataRaw->pluck('total')->toArray(),
        ];

        // Recent completed orders for table
        $recentOrders = (clone $orderQuery)->with('buyer')->latest()->take(10)->get();

        return view('seller.reports.index', compact(
            'totalSales', 
            'totalRevenue', 
            'chartData', 
            'recentOrders',
            'startDate',
            'endDate'
        ));
    }
}
