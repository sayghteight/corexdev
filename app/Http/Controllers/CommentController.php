<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body'      => 'required|string|max:2000',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ]);

        // If replying, ensure parent belongs to same post
        if ($request->parent_id) {
            $parent = Comment::findOrFail($request->parent_id);
            if ($parent->post_id !== $post->id) {
                abort(422);
            }
        }

        $approved = auth()->user()->is_admin ? true : false;

        Comment::create([
            'post_id'     => $post->id,
            'user_id'     => auth()->id(),
            'parent_id'   => $request->parent_id,
            'body'        => $request->body,
            'is_approved' => $approved,
        ]);

        $message = $approved
            ? 'Comentario publicado.'
            : 'Comentario enviado. Será visible tras aprobación.';

        return back()->with('comment_success', $message);
    }

    public function destroy(Comment $comment)
    {
        $user = auth()->user();

        if ($user->id !== $comment->user_id && ! $user->is_admin) {
            abort(403);
        }

        $comment->delete();

        return back()->with('comment_success', 'Comentario eliminado.');
    }
}
