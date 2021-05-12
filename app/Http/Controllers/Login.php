<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Login extends Controller
{
    public function postLogin(Request $request)
    {


//        $login = $request->login;
//        echo 'login: ' . $login;
//        echo '<br>';
//
//        $password = $request->password;
//        echo 'password: ' . $password;

        $login = $request->login;
        $password = $request->password;

        $exists = $users = DB::table('users')
            ->where('login', '=', $login)
            ->where('password', '=', $password)
            ->exists();

        $is_admin = $users = DB::table('users')
            ->where('login', '=', $login)
            ->where('password', '=', $password)
            ->where('admin', '=', true)
            ->exists();

        if ($exists and $is_admin) {
            $request->session()->put('login', $login);
            return redirect("/admin");
        } else if ($exists) {
            $request->session()->put('login', $login);
            return redirect("/student");
        } else {
            return redirect("/err_wrong_login");
        }

//        foreach ($users as $user) {
//            echo $user->login;
//        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('login');
        return redirect("/");
    }
}
