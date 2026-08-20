<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();
    }

    public function show($slug)
    {
        return Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }
}
