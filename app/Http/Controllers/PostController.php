<?php 
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Required for handling file deletions

class PostController extends Controller
{
    public function index()
    {
        // Eager load relationships to prevent N+1 queries
        $posts = Post::with(['user', 'categories'])->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = PostCategory::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_ids' => 'nullable|array', // Changed to nullable so users can just type a new one
            'category_ids.*' => 'exists:post_categories,id',
            'new_category' => 'nullable|string|max:255', // New validation rule
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'seo_title' => 'nullable|string|max:255',
            'keywords' => 'nullable|string|max:255',
        ]);

        // Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
            'image' => $imagePath,
        ]);

        // --- NEW CATEGORY LOGIC ---
        $categoryIds = $request->input('category_ids', []); // Default to empty array if null

        if ($request->filled('new_category')) {
            // firstOrCreate finds the category by name, or creates it using the name & slug if it doesn't exist
            $newCategory = PostCategory::firstOrCreate(
                ['name' => $request->new_category],
                ['slug' => Str::slug($request->new_category)]
            );
            
            // Add this new category ID to the array of IDs we are about to sync
            $categoryIds[] = $newCategory->id; 
        }

        // Sync the combined categories
        $post->categories()->sync($categoryIds);
        // -------------------------

        $post->meta()->create([
            'seo_title' => $validated['seo_title'],
            'keywords' => $validated['keywords'],
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'categories', 'meta', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = PostCategory::all();
        $post->load(['categories', 'meta']);
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_ids' => 'nullable|array', // Changed to nullable
            'category_ids.*' => 'exists:post_categories,id',
            'new_category' => 'nullable|string|max:255', // New validation rule
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'seo_title' => 'nullable|string|max:255',
            'keywords' => 'nullable|string|max:255',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
        ];

        // Handle Image Upload
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $updateData['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($updateData);

        // --- NEW CATEGORY LOGIC ---
        $categoryIds = $request->input('category_ids', []);

        if ($request->filled('new_category')) {
            $newCategory = PostCategory::firstOrCreate(
                ['name' => $request->new_category],
                ['slug' => Str::slug($request->new_category)]
            );
            $categoryIds[] = $newCategory->id;
        }

        $post->categories()->sync($categoryIds);
        // -------------------------

        $post->meta()->updateOrCreate(
            ['post_id' => $post->id],
            [
                'seo_title' => $validated['seo_title'],
                'keywords' => $validated['keywords'],
            ]
        );

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        // Delete the featured image from the server to free up space
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}