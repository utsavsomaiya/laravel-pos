<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $sales = Sales::all();

        return view('admin.dashboard', compact('sales'));
    }
}
