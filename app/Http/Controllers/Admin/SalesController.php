<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Models\SalesDetails;

class SalesController extends Controller
{
    public function sales()
    {
        $sales = Sales::with('discounts')->get();

        return view('admin.sales.sales', compact('sales'));
    }

    public function salesDetails($salesId)
    {
        $salesDetails = SalesDetails::with(['sales','products','discounts'])->where('sales_id', $salesId)->get();

        return view('admin.sales.sales_details', compact('salesDetails'));
    }
}
