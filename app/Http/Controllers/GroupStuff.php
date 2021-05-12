<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupStuff extends Controller
{
    public function remove(Request $request)
    {
        DB::table('groups')->where('id', '=', $request->get("id"))->delete();
        return redirect("/admin");
    }

    public function new_(Request $request)
    {
        DB::table('groups')->insert(
            array(
                'name' => $request->get("name"),
            )
        );
        return redirect("/admin");
    }
}
