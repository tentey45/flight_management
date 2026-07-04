<?php
namespace App\Http\Controllers;

use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withCount('posts')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_categories',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        PostCategory::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category created.');
    }

    public function show(PostCategory $category)
    {
        $category->load('posts');
        return view('categories.show', compact('category'));
    }

    public function edit(PostCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, PostCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_categories,name,' . $category->id,
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(PostCategory $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}