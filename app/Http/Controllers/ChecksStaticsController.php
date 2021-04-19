<?php

namespace App\Http\Controllers;

use App\Models\Check;
use Illuminate\Http\Request;

class ChecksStaticsController extends Controller
{
    public function index(Request $request)
    {
        $now = now();

        return Check::whereYear('created_at', $request->get('year', $now->year))
                ->whereMonth('created_at', $request->get('month', $now->month))
                ->get();
    }
}
