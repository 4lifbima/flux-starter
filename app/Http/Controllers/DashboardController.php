<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index with live statistics.
     */
    public function index(): View
    {
        $totalTables = Table::count();
        $activeTables = Table::where('status', 'active')->count();
        $inactiveTables = Table::where('status', 'inactive')->count();
        $totalUsers = User::count();

        $recentUsers = User::latest()->take(5)->get();
        $recentTables = Table::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalTables',
            'activeTables',
            'inactiveTables',
            'totalUsers',
            'recentUsers',
            'recentTables'
        ));
    }
}
