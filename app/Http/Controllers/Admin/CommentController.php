<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $pending  = Comment::with(['post', 'user'])->where('is_approved', false)->latest()->paginate(20, ['*'], 'pending');
        $approved = Comment::with(['post', 'user'])->where('is_approved', true)->latest()->paginate(20, ['*'], 'approved');

        return view('admin.comments.index', compact('pending', 'approved'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => ! $comment->is_approved]);

        return back()->with('success', 'Estado del comentario actualizado.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comentario eliminado.');
    }
}
