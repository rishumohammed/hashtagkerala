<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return SiteSetting::all()->pluck('value', 'key');
    }

    public function show($key)
    {
        return response()->json([
            'key' => $key,
            'value' => SiteSetting::getValue($key)
        ]);
    }
}
