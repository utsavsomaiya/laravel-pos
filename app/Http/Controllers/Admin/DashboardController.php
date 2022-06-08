<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sales;

class DashboardController extends Controller
{
    public function index()
    {
        $sales = Sales::all();

        return view('admin.dashboard', compact('sales'));
    }
}
