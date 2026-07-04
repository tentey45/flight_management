<?php 
namespace App\Http\Controllers;

use App\Models\PostComment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function index()
    {
        $comments = PostComment::with(['post', 'user'])->latest()->paginate(20);
        return view('comments.index', compact('comments'));
    }

    public function store(Request $request, Post $post)
    {
        // Assuming this is submitted from the Post's show page
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(), // null if guest, depending on your auth setup
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'Comment added!');
    }

    public function edit(PostComment $comment)
    {
        // Ensure only the author or an admin can edit
        $this->authorize('update', $comment); 
        
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, PostComment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($validated);

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comment updated.');
    }

    public function destroy(PostComment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted.');
    }
}