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
            ->get()
            ->map(function ($article) {
                return $this->formatArticle($article);
            });
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json($this->formatArticle($article));
    }

    private function formatArticle($article)
    {
        if ($article->image) {
            if (str_starts_with($article->image, '/assets/')) {
                $article->image = $article->image;
            } else {
                $article->image = filter_var($article->image, FILTER_VALIDATE_URL)
                    ? $article->image
                    : asset('storage/' . $article->image);
            }
        }
        return $article;
    }
}
