<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exam App</title>
    <link rel="stylesheet" href="https://jenil.github.io/bulmaswatch/darkly/bulmaswatch.min.css">
    <script>
        function answerToggle(id) {
            fetch("/answer_toggle?id=" + id);
            location.reload();
        }
    </script>
</head>
<body>
@include('_navbar')

<?php
use Illuminate\Support\Facades\DB;
$question = DB::table('questions')
    ->where('id', '=', request('question_id', '9999'))
    ->get()
    ->first()
?>

<section class="section">
    <div class="container content">
        <h1>{{$question->body}}</h1>
        <h6>Id: {{$question->id}}</h6>
        <h3>Answers:</h3>
        <ul>
            <?php
            $answers = DB::table('answers')->where('question_id', '=', $question->id)->get();
            foreach ($answers as $answer) {
                echo '<li>' . $answer->body . "<br> "
                    . '<a href="/answer_remove?id=' . $answer->id . "&question_id=" . $question->id
                    . '">[remove]</a> ';
                echo '[correct: ' . $answer->correct . ' <a href="#" onclick="return answerToggle(' . $answer->id . ')">toggle</a>'
                    . ']</li>';
            }
            ?>
        </ul>

        <br>

        <div class="box">
            <form action="/answer_new" method="get">
                <input type="hidden" name="id" value="{{$question->id}}">
                <label for="body" class="label">Add new answer:</label>
                <input type="text" id="body" name="body" class="input">
                <input type="submit" class="button" value="Add new answer">
            </form>
        </div>

        <br>

        <form action="/question_remove" method="get">
            <input type="hidden" name="id" class="input" value="{{$question->id}}">
            <?php
            if (count($answers) > 0)
                echo '<input type="submit" class="button" value="Can\'t remove this question - answers list not empty" disabled>';
            else
                echo '<input type="submit" class="button" value="Remove this question">';
            ?>
        </form>
    </div>
</section>

@include('_footer')
</body>
</html>
