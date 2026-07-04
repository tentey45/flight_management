<?php
namespace App\Http\Controllers;

use App\Models\PostMeta;
use App\Models\Post;
use Illuminate\Http\Request;

class PostMetaController extends Controller
{
    public function index()
    {
        $metas = PostMeta::with('post')->paginate(10);
        return view('metas.index', compact('metas'));
    }

    public function edit(PostMeta $meta)
    {
        return view('metas.edit', compact('meta'));
    }

    public function update(Request $request, PostMeta $meta)
    {
        $validated = $request->validate([
            'seo_title' => 'nullable|string|max:255',
            'keywords' => 'nullable|string|max:255',
        ]);

        $meta->update($validated);

        return redirect()->route('metas.index')->with('success', 'SEO Meta updated.');
    }
    
    // Note: store, create, and destroy are usually omitted here 
    // because Meta lifecycle is tied strictly to the Post lifecycle.
}