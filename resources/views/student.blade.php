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

$student_in_exams = DB::table('students_in_exams')
    ->where('student_id', '=', $student->id)
    ->get();
?>

<section class="section">
    <div class="container">
        <div class="section">
            <h1 class="title">Student Panel</h1>
            <a class="subtitle" href="/logout">logout</a>
            <br>
            <br>

            <div class="columns is-3">
                <div class="column content">
                    <div class="box">
                        <h3>Exams not yet done by you:</h3>
                        <ol>
                            <?php
                            foreach ($student_in_exams as $student_in_exam) {
                                if ($student_in_exam->done == false) {
                                    $exam = DB::table('exams')
                                        ->where('id', '=', $student_in_exam->exam_id)
                                        ->get()
                                        ->first();
                                    echo "<li>";
                                    echo "<form action='/exam_doing' method='post'>";
                                    echo csrf_field();
                                    echo '<input type="hidden" name="exam_id" value="' . $exam->id . '" >';
                                    echo '<input type="hidden" name="student_in_exam_id" value="' . $student_in_exam->student_id . '" >';
                                    echo '<input type="submit" class="button" value="Begin exam: \'' . $exam->title . '\'">';
                                    echo "</form>";
                                    echo "</a>";
                                    echo "</li>";
                                }
                            }
                            ?>
                        </ol>
                    </div>
                </div>
                <div class="column content">
                    <div class="box">
                        <h3>Exams that you already finished:</h3>
                        <ol>
                            <?php
                            foreach ($student_in_exams as $student_in_exam) {
                                if ($student_in_exam->done == true) {
                                    $exam = DB::table('exams')
                                        ->where('id', '=', $student_in_exam->exam_id)
                                        ->get()
                                        ->first();
                                    echo "<li>";
                                    echo "" . $exam->title;
                                    echo " - your points: " . $student_in_exam->points;
                                    echo "</li>";
                                }
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('_footer')
</body>
</html>
