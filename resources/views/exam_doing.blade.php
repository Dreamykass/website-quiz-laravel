<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exam App</title>
    <link rel="stylesheet" href="https://jenil.github.io/bulmaswatch/darkly/bulmaswatch.min.css">
</head>
<body>
@include('_navbar')

<?php
use Illuminate\Support\Facades\DB;
$student = DB::table('users')
    ->where('login', '=', Session::get('login'))
    ->get()
    ->first();

$student_in_exam_id = request('student_in_exam_id', '9999');
$exam_id = request('exam_id', '9999');

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

$questions_in_exam = $questions_in_exam->shuffle();
?>

<section class="section">
    <div class="container content">
        <h1>Exam - {{$exam->title}}</h1>
        <form method="post" action="/exam_handle_done">
            <input type="hidden" name="exam_id" value="{{$exam_id}}">
            <input type="hidden" name="student_in_exam_id" value="{{$student_in_exam_id}}">

            <ol>
                <?php
                echo csrf_field();

                foreach ($questions_in_exam as $question_in_exam) {
                    $question = DB::table('questions')
                        ->where('id', '=', $question_in_exam->question_id)
                        ->get()
                        ->first();
                    echo "<li>";
                    echo "" . $question->body;

                    echo "<ul>";
                    $answers = DB::table('answers')->where('question_id', '=', $question->id)->get();
                    $answers = $answers->shuffle();
                    foreach ($answers as $answer) {
//                        echo "<li>";
//                        echo "" . $answer->body;
//                        echo "</li>";
                        echo "<li>";
                        echo '<input type="radio" name="' . $answer->question_id . '" value="' . $answer->correct . '">';
                        echo "  " . $answer->body;
                        echo "</li>";
                    }
                    echo "</ul>";

                    echo "</li>";
                }
                ?>

            </ol>
            <br>
            <br>
            <input type="submit" class="input" value="Submit!">
        </form>
    </div>
</section>

@include('_footer')
</body>
</html>
