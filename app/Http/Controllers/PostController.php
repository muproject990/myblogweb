<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();


        return view('posts.index', [
           'posts' => $posts

        ]);
    }

    /**
     *  Show form to create a  new resource.
     */

public function create(Request $request){
    return view('posts.create');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
Post::create([
    'title'=>$request->title,
    'content'=>$request->content
]);
return to_route('posts.index');


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post=Post::find($id);

        return view('posts.show', [
            'post'=>$post

        ]);
    }
    /**
     * Edit the specified resource in storage.
     */
    public function edit(){
        return view('posts.edit', [
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
