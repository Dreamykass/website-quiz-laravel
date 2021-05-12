<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exam App</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://jenil.github.io/bulmaswatch/darkly/bulmaswatch.min.css">
</head>
<body>
@include('_navbar')

<section class="section">
    <div class="container">
        <form action="/login" method="post">
        @csrf <!-- {{ csrf_field() }} -->
            <label for="login" class="label">Login</label>
            <input type="text" id="login" name="login" placeholder="login" class="input">
            <br>
            <br>
            <label for="password" class="label">Password</label>
            <input type="text" id="password" name="password" placeholder="password" class="input">
            <br>
            <br>
            <br>
            <input type="submit" class="input" value="Enter">
        </form>
    </div>
</section>

@include('_footer')
</body>
</html>
