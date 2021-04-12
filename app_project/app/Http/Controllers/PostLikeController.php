<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Post $Post, Request $request)
    {
        if($Post->likedBy($request->user())){
            return response(null, 409);
        }

        $Post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        return back();
    }

    public function destroy(Post $Post, Request $request)
    {
        $request->user()->likes()->where('post_id', $Post->id)->delete();

        return back();
    }
}
