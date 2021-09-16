<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Users;
class UserController extends Controller
{
    public function index(Request $request)
    {
        dd($request->all());
    }
    public function getUserBasic(Request $request)
    {
        $id=($request->all())['id'];
        $user=Users::getUser($id);
        return $user;
    }
    public function getUserAdditional(Request $request)
    {
        $id=($request->all())['id'];
        $user=Users::getUserAdditional($id);
        return $user;
    }
    public function getUserCompany(Request $request)
    {
        $id=($request->all())['id'];
        $user=Users::getUserCompany($id);
        return $user;
    }
}
