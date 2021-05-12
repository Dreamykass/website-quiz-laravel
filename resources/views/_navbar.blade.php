<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item">
            <img src="https://laravel.com/img/logotype.min.svg" width="112" height="28" alt="">
        </a>
        <a class="navbar-item">
            <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28" alt="">
        </a>
        <a class="navbar-item">
            Quiz Exam App Thing
        </a>
        <?php
        $login = Session::get('login');
        if (isset($login) && $login == "ad") {
            echo '<a class="navbar-item" href="/admin">
                    Admin Panel
                </a>';
        }
        ?>

    </div>
</nav>


