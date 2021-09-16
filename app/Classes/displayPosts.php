<?php

namespace App\Classes;

class displayPosts
{
    public static function displayAll()
    {
        $posts = \DB::table('posts_of_users')->get()->toArray();
        return $posts;

    }

}
