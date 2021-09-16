<?php

namespace App\Classes;

class Posts
{
    public static function displayAll()
    {
     $posts=\DB::table('posts_of_users')->join('users_basic_info', 'userId', '=', 'users_basic_info.id')->select('posts_of_users.id','userId','title','body','users_basic_info.username')->get()->toArray();
       return $posts;
    }

}
