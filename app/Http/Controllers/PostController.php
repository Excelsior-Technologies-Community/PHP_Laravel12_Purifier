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

        })->oldest()
          ->paginate(3);

        return view('index', compact('posts'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post Deleted Successfully!');
    }
}