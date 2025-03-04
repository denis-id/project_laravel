<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3||max:255|string|unique:categories,name',
            'is_active' => 'boolean|nullable',
        ]);

        try {
            Category::create($validated);
            return redirect()->route('categories.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }

        return view('category.form', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|min:3|unique:categories,name,' . $id,
            'is_active' => 'boolean|nullable',
        ]);

        try {
            $category->update($validated);
            return redirect()->route('categories.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }

        try {
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
}