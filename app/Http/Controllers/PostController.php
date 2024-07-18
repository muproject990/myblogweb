<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posts = Post::all();
            return view('posts.index', ['posts' => $posts]);
        } catch (\Exception $e) {
            Log::error('Error fetching posts: ' . $e->getMessage());
            return view('error', ['message' => 'Unable to fetch posts. Please try again later.']);
        }
    }

    /**
     *  Show form to create a new resource.
     */
    public function create(Request $request)
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|min:5|max:255',
                'content' => 'required'
            ]);

            Post::create($validated);
            return to_route('posts.index')->with('success', 'Post created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating post: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Unable to create post. Please try again later.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            return view('posts.show', ['post' => $post]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return view('error', ['message' => 'Post not found.']);
        } catch (\Exception $e) {
            Log::error('Error showing post: ' . $e->getMessage());
            return view('error', ['message' => 'Unable to display post. Please try again later.']);
        }
    }

    /**
     * Edit the specified resource in storage.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|min:5|max:255',
                'content' => 'required'
            ]);

            $post->update($validated);
            return to_route('posts.index')->with('success', 'Post updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to update post. Please try again later.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
            return to_route('posts.index')->with('success', 'Post deleted successfully.');
        }
        catch (\Exception $e) {
            Log::error('Error deleting post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to delete post. Please try again later.');
        }
    }
}
