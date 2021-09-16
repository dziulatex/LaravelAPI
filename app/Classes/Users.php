<?php

namespace App\Classes;

class Users
{
    public static function getUser($id)
    {
        $user = \DB::table('users_basic_info')->where('username','=',$id)->get()->toArray();
        if(!empty($user)) {
            return $user[0];
        }

    }
    public static function getUserAdditional($id)
    {

        $user = \DB::table('users_additional_info')->join('users_basic_info','users_basic_info.id','=','users_additional_info.userId')->select('users_additional_info.*')->where('username','=',$id)->get()->toArray();
        if(!empty($user)) {
            return $user[0];
        }

    }
    public static function getUserCompany($id)
    {

        $user = \DB::table('users_companies')->join('users_basic_info','users_basic_info.id','=','users_companies.userId')->select('users_companies.*')->where('users_basic_info.username','=',$id)->get()->toArray();
        if(!empty($user)) {
            return $user[0];
        }
    }
    //nie wiem zbytnio jak ich przedstawic skoro nie mam nigdzie dat, tak wiec improwizuje
    public static function getMostActiveUsers()
    {
        $users = \DB::table('posts_of_users') ->join('users_basic_info', 'userId', '=', 'users_basic_info.id')
            ->select('userId','users_basic_info.username',\DB::raw('count(*) as total'))
            ->groupBy('userId','users_basic_info.username')->orderByDesc(\DB::raw('count(*)'))->take(5)
            ->get()->toArray();
        return $users;
    }
}
