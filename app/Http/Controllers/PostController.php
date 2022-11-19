<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexRequest;
use App\Http\Requests\StoreRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost(StoreRequest $request){
        $data = $request->validated();

        $post = new Post();
        $post->title = $data['title'];
        $post->body = $data['body'];
        $post->save();
    }

    public function updatePost(StoreRequest $request, $postId){
        $data = $request->validated();

        $post = Post::find($postId);
        $post->title = $data['title'];
        $post->body = $data['body'];
        $post->save();
    }

    public function deletePost($postId){
        $post = Post::find($postId);
        $post->delete();
    }

    public function getPosts(IndexRequest $request){
        $data = $request->validated();
        $posts = Post::paginate(4, ['*'], 'page', $data['page']);
        return $posts;
    }
}
