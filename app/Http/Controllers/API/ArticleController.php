<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    // Mendapatkan semua artikel
    public function getArticle()
    {
        $articles = Articles::select('id', 'slug', 'title', 'excerpt', 'published_at', 'author', 'image_url', 'is_featured', 'read_time')
            ->orderBy('published_at', 'desc')
            ->get();
        
        return response()->json($articles); 
    }

    public function getArticleBySlug($slug)
    {
        $article = Articles::select('id', 'slug', 'title', 'content', 'keywords', 'meta_description', 'excerpt', 'published_at', 'author', 'is_featured', 'read_time', 'image_url')
            ->where('slug', $slug)
            ->first();

        if (!$article) {
            return response()->json([
                'message' => 'Article not found'
            ], 404); 
        }

        return response()->json($article); 
    }

     // Menampilkan detail artikel berdasarkan slug
     public function articleDetail($slug)
     {
         $article = Articles::where('slug', $slug)->first();
         
         if (!$article) {
             return response()->json([
                 'message' => 'Article not found'
             ], 404);
         }
         
         return response()->json($article);
     } 

    public function getRelatedArticles($id)
    {
        $relatedArticles = Articles::select('id', 'slug', 'title', 'excerpt', 'published_at', 'author', 'image_url', 'read_time')
            ->where('id', '!=', $id)
            ->orderBy('published_at', 'desc')
            ->limit(3) 
            ->get();

        return response()->json($relatedArticles);
    }

    public function featuredArticle()
    {
        $featuredArticles = Articles::where('is_featured', true)
            ->select('id', 'slug', 'title', 'excerpt', 'published_at', 'author', 'image_url', 'read_time')
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json($featuredArticles);
    }

    public function createArticle(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'slug' => 'required|unique:articles',
            'title' => 'required',
            'content' => 'required',
            'keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'excerpt' => 'nullable',
            'published_at' => 'nullable|date',
            'author' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'read_time' => 'nullable|integer',
            'image_url' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400); 
        }

        // Membuat artikel baru
        $article = Articles::create($request->all());

        return response()->json([
            'message' => 'Article created successfully',
            'data' => $article
        ], 201); 
    }
}