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
        $name="aavash";
        $age="32";
        $post=[
            'post1',
            'post2 ',
            'post3'
        ];

        return view('posts.index', [
            'name'=>$name,
            'AGE'=>$age,
            'posts'=>$post

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('posts.show', [

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
