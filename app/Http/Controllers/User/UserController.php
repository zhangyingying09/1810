<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;

class UserController extends Controller
{
    public function login(){
        echo __METHOD__;

        $data=$_POST;
        echo "<pre>";print_r($data);echo "</pre>";die;
        $res=UserModel::insertGetId($data);
    }
}
