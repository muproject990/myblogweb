<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
            return view('posts.index', compact('posts'));
        } catch (\Exception $e) {
            Log::error('Error fetching posts: ' . $e->getMessage());
            return view('error', ['message' => 'Unable to fetch posts. Please try again later.']);
        }
    }

    /**
     *  Show form to create a new resource.
     */
    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Post creation started.');

            $validated = $request->validate([
                'title' => 'required|min:5|max:255',
                'content' => 'required'
            ]);

            $post = auth()->user()->posts()->create($validated);

            if ($post) {
                Log::info('Post created successfully.');
                return redirect()->route('posts.index')->with('success', 'Post created successfully.');
            } else {
                Log::error('Post creation failed at database level.');
                return redirect()->back()->with('error', 'Unable to create post. Please try again later.')->withInput();
            }
        } catch (ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('General error creating post: ' . $e->getMessage());
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
            return view('posts.show', compact('post'));
        } catch (ModelNotFoundException $e) {
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
        try {
            Gate::authorize('update', $post);
            return view('posts.edit', compact('post'));
        } catch (AuthorizationException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        try {
            Gate::authorize('update', $post);

            $validated = $request->validate([
                'title' => 'required|min:5|max:255',
                'content' => 'required'
            ]);

            $post->update($validated);
            return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
        } catch (AuthorizationException $e) {
            return redirect()->back()->with('error', 'You are not authorized to update this post.');
        } catch (ValidationException $e) {
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
            Gate::authorize('delete', $post);
            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        } catch (AuthorizationException $e) {
            return redirect()->back()->with('error', 'Not authorized. Unable to delete post.');
        } catch (\Exception $e) {
            Log::error('Error deleting post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to delete post. Please try again later.');
        }
    }
}
