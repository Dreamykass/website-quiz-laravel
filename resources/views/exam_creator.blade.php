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
$questions = DB::table('questions')->get();
$groups = DB::table('groups')->get();
$students = DB::table('users')->where('admin', '=', false)->where('group_id', '=', null)->get();
?>

<section class="section">
    <div class="container content">
        <h1>Create a exam!</h1>
        <form action="/exam_create" method="get">

            <section class="section">
                <label for="title" class="label">Title:</label>
                <input type="text" class="input" name="title" id="title">
            </section>

            <section class="section">
                <h4>Select questions:</h4>
                <?php
                foreach ($questions as $question) {
                    echo '<input type="checkbox" name="questions[]" value="'
                        . $question->id
                        . '"> ' . $question->body
                        . '</input><br>';
                }
                ?>
            </section>

            <section class="section">
                <h4>Select groups:</h4>
                <?php
                foreach ($groups as $group) {
                    echo '<input type="checkbox" name="groups[]" value="'
                        . $group->id
                        . '"> ' . $group->name
                        . '</input><br>';
                }
                ?>
            </section>

            <section class="section">
                <h4>Select group-less students:</h4>
                <?php
                foreach ($students as $student) {
                    echo '<input type="checkbox" name="students[]" value="'
                        . $student->id
                        . '"> ' . $student->login
                        . '</input><br>';
                }
                ?>
            </section>

            <input type="submit" class="input" value="Create!">

        </form>
    </div>
</section>

@include('_footer')
</body>
</html>
