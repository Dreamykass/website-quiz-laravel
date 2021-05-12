<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionStuff extends Controller
{
    public function question_remove(Request $request)
    {
        DB::table('questions')->where('id', '=', $request->get("id"))->delete();
        return redirect("/admin");
    }

    public function answer_remove(Request $request)
    {
        DB::table('answers')->where('id', '=', $request->get("id"))->delete();
        return redirect("/question?question_id=" . $request->input("question_id"));
    }

    public function answer_toggle(Request $request)
    {
        $c = DB::table('answers')
                ->where('id', '=', $request->get("id"))
                ->get()
                ->first()
                ->correct ^ 1;

        DB::table('answers')
            ->where('id', '=', $request->get("id"))
            ->update(['correct' => $c]);

        return redirect("/admin");
    }

    public function question_new(Request $request)
    {
        DB::table('questions')->insert(
            array(
                'body' => $request->get("body"),
            )
        );
        return redirect("/admin");
    }

    public function answer_new(Request $request)
    {
        DB::table('answers')->insert(
            array(
                'body' => $request->input("body"),
                'question_id' => $request->input("id"),
            )
        );
        return redirect("/question?question_id=" . $request->input("id"));
    }
}
