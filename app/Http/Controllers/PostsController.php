<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response;
use App\Classes\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function getPosts(Request $request)
    {
        $posts=Posts::displayAll();
        return $posts;

    }
}
