<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ModeratorCommentController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'pending');

        $comments = Comment::with(['user', 'product'])
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        $stats = [
            'pending' => Comment::where('status', 'pending')->count(),
            'approved' => Comment::where('status', 'approved')->count(),
            'rejected' => Comment::where('status', 'rejected')->count(),
            'total' => Comment::count(),
        ];

        return view('admin.moderator.comments.index', compact('comments', 'stats', 'status'));
    }

    public function show(Comment $comment): View
    {
        $comment->load(['user', 'product', 'approver']);
        return view('admin.moderator.comments.show', compact('comment'));
    }

    public function approve(Comment $comment): RedirectResponse
    {
        $comment->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('moderator.comments.index')
            ->with('success', 'Ulasan berhasil disetujui.');
    }

    public function reject(Request $request, Comment $comment): RedirectResponse
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $comment->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('moderator.comments.index')
            ->with('success', 'Ulasan berhasil ditolak.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('moderator.comments.index')
            ->with('success', 'Ulasan berhasil dihapus.');
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
            'action' => 'required|in:approve,reject,delete',
        ]);

        $comments = Comment::whereIn('id', $request->comment_ids)->get();

        switch ($request->action) {
            case 'approve':
                foreach ($comments as $comment) {
                    $comment->update([
                        'status' => 'approved',
                        'approved_at' => now(),
                        'approved_by' => auth()->id(),
                    ]);
                }
                $message = 'Ulasan berhasil disetujui.';
                break;

            case 'reject':
                foreach ($comments as $comment) {
                    $comment->update([
                        'status' => 'rejected',
                        'approved_at' => now(),
                        'approved_by' => auth()->id(),
                    ]);
                }
                $message = 'Ulasan berhasil ditolak.';
                break;

            case 'delete':
                Comment::whereIn('id', $request->comment_ids)->delete();
                $message = 'Ulasan berhasil dihapus.';
                break;
        }

        return redirect()->route('moderator.comments.index')
            ->with('success', $message);
    }
}
