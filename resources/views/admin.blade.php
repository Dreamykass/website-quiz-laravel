<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exam App</title>
    <link rel="stylesheet" href="https://jenil.github.io/bulmaswatch/darkly/bulmaswatch.min.css">
</head>
<script> {{-- ================================================================================================== --}}
    function studentRename(id) {
        var person = prompt("Please enter new login:", "Harry Potter");
        if (person == null || person == "") {
            // txt = "User cancelled the prompt.";
        } else {
            // txt = "Hello " + person + "! How are you today?";
            window.location.href = "/student_rename?id=" + id + "&login=" + person;
        }
    }

    function studentPassword(id) {
        var person = prompt("Please enter new password:", "**********");
        if (person == null || person == "") {
        } else {
            window.location.href = "/student_change_password?id=" + id + "&password=" + person;
        }
    }

    function addToGroup(id) {
        var person = prompt("Group name:", "english");
        if (person == null || person == "") {
        } else {
            window.location.href = "/student_add_to_group?id=" + id + "&name=" + person;
        }
    }

</script>
<body>
@include('_navbar')

<section class="section">
    <div class="container">
        <div class="section">
            <h1 class="title">Admin Panel</h1>
            <a class="subtitle" href="/logout">logout</a>
        </div>
        <div class="columns is-3">
            <div class="column content">
                <div class="box">
                    <h2>Students:</h2>
                    <sup>login (password)</sup>
                    <ol>
                        <?php
                        use Illuminate\Support\Facades\DB;
                        $users = DB::table('users')->get();
                        foreach ($users as $user) {
                            if ($user->admin) {
//                                echo "<strong>[admin] " . $user->login . " </strong>";
//                                echo "(" . $user->password . ") ";
//                                echo "<br> - ";
                                echo "<br>";
                            } else {
                                echo "<li>";
                                echo "<a href='/student_edit?student_id=$user->id'><strong>" . $user->login . " </strong>";
                                echo "<sup>(" . $user->password . ")</sup></a>";

                                if (isset($user->group_id)) {
                                    echo "<br>" . DB::table('groups')->where('id', '=', $user->group_id)->get()->first()->name;
                                } else {
                                    echo "<br><sup>not in group</sup>";
                                }

                                echo "<br>";
                                echo "</li>";
                            }
                        }
                        ?>
                    </ol>

                    <br>
                    <br>

                    <form action="/student_new" method="get">
                    @csrf <!-- {{ csrf_field() }} -->
                        <label for="login" class="label">New student's login</label>
                        <input type="text" id="login" name="login" placeholder="login" class="input"><br>
                        <label for="password" class="label">New student's password</label>
                        <input type="text" id="password" name="password" placeholder="password" class="input"><br>
                        <input type="submit" value="Add" class="input">
                    </form>
                </div>
            </div>
            <div class="column content">
                <div class="box">
                    <h2>Groups</h2>
                    <ul>
                        <?php
                        $groups = DB::table('groups')->get();
                        foreach ($groups as $group) {
                            $uu = DB::table('users')->where('group_id', '=', $group->id)->get();
                            echo "<li><strong>" . $group->name . " </strong> ";

                            if (count($uu) == 0)
                                echo '<a href="/group_remove?id=' . $group->id . '">[delete this group]</a>';
                            else
                                echo "<sup>[can't delete - not empty]</sup>";

                            echo "<br><ol>";
                            foreach ($uu as $u) {
                                echo "<li>" . $u->login . "";
                                echo '<a href="/student_remove_from_group?id=' . $u->id . '"> [remove from group]</a>';
                                echo "</li>";
                            }
                            echo "";
                            echo "</li></ol><br>";
                        }
                        ?>
                    </ul>

                    <form action="/group_new" method="get">
                        <label for="name" class="label">New group:</label>
                        <input type="text" id="name" name="name" class="input"><br>
                        <input type="submit" class="input" value="Add">
                    </form>

                </div>
            </div>
            <div class="column content">
                <div class="box">
                    <h2>Questions</h2>
                    <ul>
                        <?php
                        $questions = DB::table('questions')->get();
                        foreach ($questions as $question) {
                            echo "<li><a href='/question?question_id=" . $question->id . "'>" . $question->body . "</a></li><br>";
//                        $answers = DB::table('answers')->where('question_id', '=', $question->id)->get();
//                        foreach ($answers as $answer) {
//                            echo '<br> - ' . $answer->body . " " . '<a href="/answer_remove?id=' . $answer->id . '">[remove]</a> ';
//                            echo '[correct: ' . $answer->correct . ' <a href="#" onclick="return answerToggle(' . $answer->id . ')">toggle</a>' . ']';
//                        }
//                        echo "";
//                        echo '<br> - ' . '<a href="#" onclick="return newAnswer(' . $question->id . ')"> [new answer]</a > <br>';
                        }
                        //                    echo '<strong>' . '<a href="#" onclick="return newQuestion()"> [new question]</a > </strong>';
                        ?>
                    </ul>
                    <br>
                    <form action="/question_new" method="get">
                        <label for="body" class="label">New question:</label>
                        <input type="text" id="body" name="body" class="input">
                        <input type="submit" class="input" value="Add">
                    </form>
                </div>
            </div>
            <div class="column content">
                <div class="box">
                    <h2>Exams</h2>
                    <ul>
                        <?php
                        $exams = DB::table('exams')->get();
                        foreach ($exams as $exam) {
                            echo '<li> <a href="/exam?exam_id=' . $exam->id . '">';
                            echo "" . $exam->title . "";
                            echo " </a ></li ><br > ";
                        }
                        ?>
                    </ul>
                    <br>

                    <a href="/exam_creator" class="input">Create a new exam</a>

                    {{--                    <form action="/exam_new" method="get">--}}
                    {{--                        <label for="title" class="label">New exam:</label>--}}
                    {{--                        <input type="text" id="title" name="title" class="input">--}}
                    {{--                        <input type="submit" class="input" value="Add">--}}
                    {{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
</section>

@include('_footer')
</body>
</html>
