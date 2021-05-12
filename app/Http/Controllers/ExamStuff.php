<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamStuff extends Controller
{
    public function exam_new(Request $request)
    {
        DB::table('exams')->insert(
            array(
                'title' => $request->get("title"),
            )
        );
        return redirect("/admin");
    }

    public function exam_create(Request $request)
    {
        $title = $request->input("title");
        $questions = $request->input("questions");
        $students = $request->input("students");
        $groups = $request->input("groups");

        $exam_id = DB::table('exams')->insertGetId(
            array(
                'title' => $title,
            )
        );

        if (isset($questions)) {
            foreach ($questions as $question_id) {
                DB::table('questions_in_exams')->insert(
                    array(
                        'question_id' => $question_id,
                        'exam_id' => $exam_id,
                    )
                );
            }
        }

        if (isset($questions)) {
            foreach ($students as $student_id) {
                DB::table('students_in_exams')->insert(
                    array(
                        'student_id' => $student_id,
                        'exam_id' => $exam_id,
                    )
                );
            }
        }

        if (isset($groups)) {
            foreach ($groups as $group_id) {
                $students = DB::table('users')->where('group_id', '=', $group_id)->get();

                foreach ($students as $student) {
                    DB::table('students_in_exams')->insert(
                        array(
                            'student_id' => $student->id,
                            'exam_id' => $exam_id,
                        )
                    );
                }
            }
        }

        return redirect("/admin");
    }

    public function exam_handle_done(Request $request)
    {
        $student_in_exam_id = $request->input("student_in_exam_id");
        $exam_id = $request->input("exam_id");

        $student_in_exam = DB::table('students_in_exams')
            ->where('student_id', '=', $student_in_exam_id)
            ->where('exam_id', '=', request('exam_id', '9999'))
            ->get()
            ->first();

        $exam = DB::table('exams')
            ->where('id', '=', $exam_id)
            ->get()
            ->first();

        $questions_in_exam = DB::table('questions_in_exams')
            ->where('exam_id', '=', $exam_id)
            ->get();

        $points = 0;

        foreach ($questions_in_exam as $question_in_exam) {
            $point = request($question_in_exam->question_id, '0');
            $points += $point;
        }

        DB::table('students_in_exams')
            ->where('student_id', '=', $student_in_exam_id)
            ->where('exam_id', '=', $exam_id)
            ->update(['points' => $points]);
        DB::table('students_in_exams')
            ->where('student_id', '=', $student_in_exam_id)
            ->where('exam_id', '=', $exam_id)
            ->update(['done' => true]);

//        echo $points;

        return redirect("/student");
    }
}
