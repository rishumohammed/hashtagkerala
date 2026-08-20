<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Hotel;
use App\Models\Tag;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'districts' => District::count(),
            'hotels' => Hotel::count(),
            'tags' => Tag::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
