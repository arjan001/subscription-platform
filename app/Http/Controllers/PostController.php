<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function store(Request $request, $websiteId)
{
    $validated = $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
    ]);

    $website = Website::findOrFail($websiteId);

    $post = $website->posts()->create($validated);

    return response()->json($post, 201);
}

}
