<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentStuff extends Controller
{
    public function remove(Request $request)
    {
        DB::table('users')->where('id', '=', $request->get("id"))->delete();
        return redirect("/admin");
    }

    public function new_(Request $request)
    {
//        DB::table('users')->where('id', '=', $request->get("id"))->delete();
        DB::table('users')->insert(
            array(
                'login' => $request->get("login"),
                'password' => $request->get("password"),
                'admin' => false,
            )
        );
        return redirect("/admin");
    }

    public function rename(Request $request)
    {
        DB::table('users')
            ->where('id', '=', $request->get("id"))
            ->update(['login' => $request->get("login")]);
        return redirect("/admin");
    }

    public function change_password(Request $request)
    {
        DB::table('users')
            ->where('id', '=', $request->get("id"))
            ->update(['password' => $request->get("password")]);
        return redirect("/admin");
    }

    public function remove_from_group(Request $request)
    {
        DB::table('users')
            ->where('id', '=', $request->get("id"))
            ->update(['group_id' => null]);
        return redirect("/student_edit?student_id=" . $request->get("id"));
    }

    public function add_to_group(Request $request)
    {
        $group = DB::table('groups')
            ->where('name', '=', $request->get("group_name"))
            ->get()
            ->first();

        if (isset($group))
            DB::table('users')
                ->where('id', '=', $request->get("id"))
                ->update(['group_id' => $group->id]);

        return redirect("/student_edit?student_id=" . $request->get("id"));
    }
}
