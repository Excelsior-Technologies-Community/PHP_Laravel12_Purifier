<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Purifier;


class PostController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Post::create([
            'title' => $request->title,
            'description' => Purifier::clean($request->description)
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post Saved Successfully!');
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $posts = Post::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })
            ->oldest()
            ->paginate(3);

        return view('index', compact('posts'));
    }

    // ✏️ EDIT PAGE
    public function edit(Post $post)
    {
        return view('edit', compact('post'));
    }

    // 🔄 UPDATE POST
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $raw = $request->description;
        $clean = Purifier::clean($raw);

        $post->update([
            'title' => $request->title,
            'description' => $clean,
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post Updated Successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post Deleted Successfully!');
    }

    public function export()
    {
        $fileName = 'posts.csv';

        $posts = Post::all();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($posts) {
            $file = fopen('php://output', 'w');

            // CSV header
            fputcsv($file, ['ID', 'Title', 'Description', 'Created At']);

            foreach ($posts as $post) {
                fputcsv($file, [
                    $post->id,
                    $post->title,
                    strip_tags($post->description),
                    $post->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
