<?php

namespace App\Http\Controllers;

use App\Mail\PostMail;
use App\Models\Comment;
use App\Models\Post;
use Dflydev\DotAccessData\Data;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posts = Post::paginate(3);
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
                'content' => 'required',
                'image' => ['required', 'image']
            ]);

            // Handle file upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validated['image'] = $imagePath;
            } else {
                throw new \Exception('Image file is required.');
            }
            $post = auth()->user()->posts()->create($validated);
            Mail::to("tyimisip457@modotso.com")->send(new PostMail());

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
            return view('posts.show', ['post' => $post], );
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
                'content' => 'required',
                'image' => ['sometimes', 'image']

            ]);

            if ($request->hasFile('image')) {

                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }

                $validated['image'] = $request->file('image')->store('images', 'public');
            }

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
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        } catch (AuthorizationException $e) {
            return redirect()->back()->with('error', 'Not authorized. Unable to delete post.');
        } catch (\Exception $e) {
            Log::error('Error deleting post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to delete post. Please try again later.');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('search');

        $posts = Post::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->paginate(10);

        return view('posts.index', compact('posts', 'query'));
    }
    public function storeComment(Request $request, $postId)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Log the user ID and post ID
        Log::info('Adding comment', ['postId' => $postId, 'userId' => auth()->id()]);

        $comment = new Comment([
            'content' => $request->content,
            'post_id' => $postId,
            'user_id' => auth()->id(),
        ]);

        $comment->save();

        return response()->json(['success' => true]);
    }



}
