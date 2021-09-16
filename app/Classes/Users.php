<?php

namespace App\Classes;

class Users
{
    public static function getUser($id)
    {
        $user = \DB::table('users_basic_info')->where('id','=',$id)->get()->toArray();
        if(!empty($user)) {
            return $user[0];
        }

    }
    public static function getUserAdditional($id)
    {

        $user = \DB::table('users_additional_info')->where('userId','=',$id)->get()->toArray();
        if(!empty($user)) {
            return $user[0];
        }

    }
    public static function getUserCompany($id)
    {

        $user = \DB::table('users_companies')->where('userId','=',$id)->get()->toArray();
        if(!empty($user)) {
            return $user[0];
        }

    }
}
