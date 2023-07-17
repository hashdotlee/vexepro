<html>

<head>
    <title> Tôi </title>
    <link rel="stylesheet" href="/vexepro/app/views/Home.css" />
    <link rel="stylesheet" href="/vexepro/app/views/Me.css" />
    <link rel="stylesheet" href="/vexepro/app/views/TripMana.css" />
</head>

<body>

    <?php
    require_once _DIR_ROOT . '/app/views/AdminNavbar.php';
    ?>
    <main>
        <div class="container">
            <div class="card">
                <div class="row" id="row">
                    <div class="col-l border-r" id="tab-menu">
                    </div>
                    <div class="col-r" id="tab-content">
                    </div>
                    <script type='text/javascript'>
                        const tabs = [{
                                title: 'Danh sách khách hàng',
                                id: 'tab-1',
                                render: `
                                    <div>
                                        <form action='/vexepro/user/manage' method='GET'>
                                            <div style='margin-bottom: 8px'>
                                                <label style='display: inline-block'>Tìm kiếm: </label>
                                                <input class='form-item' value='<?php if(array_key_exists('search', $_GET)) echo $_GET['search']?>' name='search' placeholder='Nhập ID, tên đăng nhập, tên, ngày sinh, SĐT, Email hoặc địa chỉ để tìm kiếm'/>
                                                <select name='status' style='padding: 8px'>
                                                    <option value='0' <?php if((array_key_exists('status', $_GET)) && ($_GET['status'] == '0')) echo 'selected=\'(true)\'' ?>'>Hoạt động</option>
                                                    <option value='1' <?php if ((array_key_exists('status', $_GET)) &&  ($_GET['status'] == '1')) echo 'selected=\'(true)\'' ?>'>Vô hiệu hóa</option>
                                                </select>
                                                <button type='submit' class='button'>Tìm kiếm</button>
                                            </div>
                                        </form>
                                    <table>
                                    <tr>
                                        <th> ID</th>
                                        <th> Tên đăng nhập</th>
                                        <th> Tên</th>
                                        <th> Ngày sinh</th>
                                        <th> Số điện thoại</th>
                                        <th> Email</th>
                                        <th> Địa chỉ</th>
                                        <th> Vô hiệu hóa</th>
                                    </tr>
                                    <?php foreach ($users as $user) {
                                        print('<tr>
                                                <td>' . $user->id . '</td>
                                                <td>' . $user->username . '</td>
                                                <td>' . $user->name . '</td>
                                                <td>' . $user->dob . '</td>
                                                <td>' . $user->tel . '</td>
                                                <td>' . $user->email . '</td>
                                                <td>' . $user->address . '</td>
                                                <td>' . ($user->deactivate_flag == 1 ? "Có" : "Không") . '</td>
                                                </tr>');
                                    }
                                    ?>
                                    </table>
                                </div>
                                `
                            },
                            {
                                title: 'Thêm người dùng',
                                id: 'tab-2',
                                render: `
                                <form action='/vexepro/user/add'>
                                    <div class='form-wrapper'>
                                        <label>Tên đăng nhập</label>
                                        <input class='form-item' name='username' value=''/>
                                    </div>
                                    <div class='form-wrapper'>
                                        <label> Mật khẩu</label>
                                        <input type='password' class='form-item' name='password' value=''/>
                                    </div>
                                    <div class='form-wrapper'>
                                        <label> Họ và tên</label>
                                        <input class='form-item' name='name' value=''/>
                                    </div>
                                    <div class='form-wrapper'>
                                        <label> Số điện thoại</label>
                                        <input class='form-item' name='tel' value=''/>
                                    </div>
                                    <div class='form-wrapper'>
                                        <label> Địa chỉ</label>
                                        <input class='form-item' name='address' value=''/>
                                    </div>
                                    <div class='form-wrapper'>
                                        <label> Ngày sinh</label>
                                        <input class='form-item' name='dob' type='date' value=''/>
                                    </div>
                                    <div class='form-wrapper'>
                                        <label>Email</label>
                                        <input class='form-item' name='email' type='email' value=''/>
                                    </div>
                                    <div class='form-wrapper'>
                                        <label> Phân quyền</label>
                                        <select class='form-item' name='role'>
                                            <option value='admin'>Admin</option>
                                            <option value='customer'>Customer</option>
                                        </select>
                                    </div>
                                    <button class='button primary-button'>Thêm người dùng</button>
                                </form>
            `
                            },
                            {
                                title: 'Vô hiệu hóa người dùng',
                                id: 'tab-3',
                                render: `
                                <div>
                                <form action='/vexepro/user/deactivate'>
                                    <div class='form-wrapper'>
                                        <label>Nhập id</label>
                                        <input class='form-item' name='id'/>
                                    </div>
                                    <button class='button primary-button'>Vô hiệu hóa</button>
                                </form>
                                `
                            }
                        ];
                        let activeTab = tabs[0].id;
                        let menu = document.getElementById('tab-menu');
                        let content = document.getElementById('tab-content');
                        content.innerHTML = tabs[0].render;
                        tabs.forEach(item => {
                            let element = document.createElement('div');
                            element.classList.add('tab-item');
                            element.id = item.id;
                            element.onclick = function() {
                                onChangeTab(item)
                            };
                            element.innerText = item.title;
                            menu.appendChild(element);
                        })
                        document.getElementById(activeTab).classList.add('active');

                        function onChangeTab(tab) {
                            content.innerHTML = tab.render;
                            document.getElementById(activeTab).classList.remove('active');
                            document.getElementById(tab.id).classList.add('active');
                            activeTab = tab.id;
                        }
                    </script>
                </div>
            </div>
        </div>
    </main>
</body>

</html>