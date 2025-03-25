<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    // Menampilkan daftar artikel
    public function index(Request $request)
    {
        $search = $request->input('search');
        $articles = Articles::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                         ->orWhere('author', 'like', "%{$search}%");
        })->latest()->get();
      
        return view('articles.index', compact('articles'));
    }

    // Menampilkan form tambah artikel
    public function create()
    {
        return view('articles.form');
    }

    // Menyimpan artikel baru ke database
    public function store(Request $request)
    {
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Articles::create($request->all());
        return redirect()->route('articles.index')->with('success', 'Article created successfully');
    }

    // Menampilkan detail artikel
    public function show($id)
    {
        $article = Articles::findOrFail($id);
        return view('articles.show', compact('article'));
    }

    // Menampilkan form edit artikel
    public function edit($id)
    {
        $article = Articles::findOrFail($id);
        return view('articles.form', compact('article'));
    }

    // Memperbarui artikel
    public function update(Request $request, $id)
    {
        $article = Articles::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'slug' => 'required|unique:articles,slug,' . $article->id,
            'title' => 'required',
            'content' => 'required',
            'keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'excerpt' => 'nullable',
            'published_at' => 'nullable|date',
            'author' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'read_time' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $article->update($request->all());
        return redirect()->route('articles.index')->with('success', 'Article updated successfully');
    }

    // Menghapus artikel
    public function destroy($id)
    {
        $article = Articles::findOrFail($id);
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully');
    }
}