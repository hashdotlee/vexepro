<html>

<head>
    <title> Đăng nhập</title>
    <link rel="stylesheet" href="/vexepro/app/views/Login.css" />
</head>

<body>
    <?php
    if (array_key_exists("login", $error)) printf("<script>alert('%s')</script>", $error["login"]);
    ?>
    <div class="container">
        <div class="login-wrapper container">
            <div>
                <div class="brand-name">Vé Xe Pro</div>
                <img src="/vexepro/app/assets/images/logo.png" alt="logo" class="logo" />
            </div>

            <form action="/vexepro/user/login" method="POST" class="form">
                <label>Tên người dùng</label>
                <input name="username" placeholder="Nhập tên người dùng" class="form-item" />
                <label>Mật khẩu</label>
                <input name="password" placeholder="Nhập mật khẩu" type="password" class="form-item" />
                <button type="submit" class=" button primary-button">Đăng nhập</button>
                <a role="button" type="button" style="border: 1px solid rgba(0,0,0,0.15); color: black; text-decoration: none; padding: 4px 8px; display:flex; align-items: center; justify-content: center; border-radius: 8px;" href="/vexepro/auth/register"> Đăng ký </a>
            </form>
        </div>
    </div>
</body>

</html>