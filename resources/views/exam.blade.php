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
$exam_id = request('exam_id', '9999');
$exam = DB::table('exams')
    ->where('id', '=', $exam_id)
    ->get()
    ->first();

$questions_in_exam = DB::table('questions_in_exams')
    ->where('exam_id', '=', $exam_id)
    ->get();
$students_in_exam = DB::table('students_in_exams')
    ->where('exam_id', '=', $exam_id)
    ->get();
?>

<section class="section">
    <div class="container content">
        <h1>Exam - {{$exam->title}}</h1>
        <br>
        <br>

        <section class="section">
            <h3>Students assigned to this exam:</h3>
            <ol>
                <?php
                foreach ($students_in_exam as $student_in_exam) {
                    $student = DB::table('users')
                        ->where('id', '=', $student_in_exam->student_id)
                        ->get()->first();
                    echo '<li>';
                    echo '' . $student->login . "<br>";
                    if ($student_in_exam->done) {
                        echo 'Finished with this many points: ' . $student_in_exam->points . "<br>";
                    } else {
                        echo 'Not yet finished the exam...<br>';
                    }
                    echo '</li>';
                }
                ?>
            </ol>
        </section>

        <section class="section">
            <h3>Questions in this exam:</h3>
            <ol>
                <?php
                foreach ($questions_in_exam as $question_in_exam) {
                    $question = DB::table('questions')
                        ->where('id', '=', $question_in_exam->question_id)
                        ->get()->first();
                    echo '<li>';
                    echo '' . $question->body . "<br>";
                    echo '</li>';
                }
                ?>
            </ol>
        </section>

        <br>
        <br>

    </div>
</section>

@include('_footer')
</body>
</html>
