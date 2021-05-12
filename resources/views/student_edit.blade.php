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
    ->where('id', '=', request('student_id', '9999'))
    ->get()
    ->first();
$groups = DB::table('groups')->get();
?>

<section class="section">
    <div class="container content">
        <h1>Student - {{$student->login}}</h1>
        <strong>Id in database: {{$student->id}}</strong><br>
        <strong>Password:</strong> {{$student->password}}<br>
        <br>

        Group:
        <?php
        if (isset($student->group_id)) {
            echo DB::table('groups')->where('id', '=', $student->group_id)->get()->first()->name;
            echo "<br>";
            echo '<a href="/student_remove_from_group?id=' . $student->id . '" class="button">Remove from group</a>';
            echo "<br>";
        } else {
            echo "Not in group...";
            echo '
                <form action="/student_add_to_group" method="get" class="box">
                    <input type="hidden" name="id" class="input" value="' . $student->id . '">
                    <label for="group_name" class="label">Pick a group:</label>
                    <div class="select">
                    <select id="group_name" name="group_name">
            ';
            foreach ($groups as $group) {
                echo '<option value="' . $group->name . '">' . $group->name . '</option>';
            }
            echo '
                    </select>
                    </div>
                    <input type="submit" class="button" value="Add to this group">
                </form>
            ';
        }
        ?>

        <form action=" /student_remove" method="get">
            <input type="hidden" name="id" class="input" value="{{$student->id}}">
            <input type="submit" class="button" value="Delete this student account">
        </form>

    </div>
</section>

@include('_footer')
</body>
</html>
