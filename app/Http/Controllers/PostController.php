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

        return redirect()->back()->with('success', 'Post Saved Successfully!');
    }
}
