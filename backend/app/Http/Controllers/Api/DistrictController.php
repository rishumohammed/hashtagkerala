<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = \App\Models\District::all()->map(function ($district) {
            if ($district->image_path) {
                if (str_starts_with($district->image_path, '/assets/')) {
                    $district->image = $district->image_path;
                } else {
                    $district->image = filter_var($district->image_path, FILTER_VALIDATE_URL) 
                        ? $district->image_path 
                        : asset('storage/' . $district->image_path);
                }
            }
            return $district;
        });

        return response()->json([
            'status' => 'success',
            'data' => $districts
        ]);
    }
}
