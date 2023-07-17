<nav class="navbar">
    <a href="/vexepro/user/manage" style="text-decoration: none; color: black" class="logo">
        <img src="/vexepro/app/assets/images/logo.png" alt="logo" />
        VÉ XE PRO
    </a>
    <div class="navbar-left">
        <?php
        if (array_key_exists('adminObj', $_SESSION)) {

            print("<a class='button' href='/vexepro/user/manage'>Người dùng</a>
                    <a class='button' href='/vexepro/station/manage'>Bến xe</a>
                    <a class='button' href='/vexepro/agency/manage'>Nhà xe</a>
                    <a class='button' href='/vexepro/vehicle/manage'>Xe</a>
                    <a class='button' href='/vexepro/ticket/manage'>Vé</a>
                    <a class='button' href='/vexepro/trip/manage'>Chuyến</a>
                    <a class='button' href='/vexepro/requests/manage'>Yêu cầu</a>
                    <a class='button' href='/vexepro/complain/manage'>Khiếu nại</a>
                    <a class='button' href='/vexepro/user/logout'>Đăng xuất</a>
                    ");
        } else {
            print('<a class="button primary-button" href="/vexepro/auth/login">Đăng nhập</a>
                <a class="button secondary-button" href="/vexepro/auth/register">Đăng ký</a>');
        }
        ?>
    </div>
</nav>