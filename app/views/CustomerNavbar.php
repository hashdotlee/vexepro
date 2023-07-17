<nav class="navbar">
    <a href="/vexepro" style="text-decoration: none; color: black" class="logo">
        <img src="/vexepro/app/assets/images/logo.png" alt="logo"/>
        VÉ XE PRO
    </a>
    <div class="navbar-left">
        <?php
        if (array_key_exists('userObj', $_SESSION)) {
            print("<a class='button' href='/vexepro/home/me'>Tôi</a>
            <a class='button' href='/vexepro/complain/index'>Hỗ trợ</a>
            ");
        } else {
            print('<a class="button primary-button" href="/vexepro/auth/login">Đăng nhập</a>
                <a class="button secondary-button" href="/vexepro/auth/register">Đăng ký</a>');
        }
        ?>
    </div>
</nav>