<html>

<head>
    <title> Bến xe </title>
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
                                title: 'Danh sách bến',
                                id: 'tab-1',
                                render: `
                                    <div>
                                        <form action='/vexepro/station/manage' method='GET'>
                                        <div style='margin-bottom: 8px'>
                                            <label style='display: inline-block'>Tìm kiếm: </label>
                                            <input class='form-item' name='search' placeholder='Nhập ID, tên, hoặc địa chỉ để tìm kiếm'/>
                                        </div>
                                        <button class='button' type='submit'> Tìm kiếm </button>
                                        </form>
                                        <table>
                                            <tr>
                                                <th>Mã nhà xe</th>
                                                <th>Tên</th>
                                                <th>Địa chỉ</th>
                                            </tr>
                                    <?php
                                    foreach ($stations as $station) {
                                        print ' <tr>
                                                        <td>' . $station->id . '</td>
                                                        <td>' . $station->name . '</td>
                                                        <td>' . $station->province . '</td>
                                                    </tr>';
                                    }
                                    ?>

                                        </table>
                                    </div>
                                 `
                            },
                            {
                                title: 'Thêm bến xe',
                                id: 'tab-2',
                                render: `
                                    <form action='/vexepro/station/add'>
                                        <div class='form-wrapper'>
                                            <label> Tên nhà xe</label>
                                            <input class='form-item' name='name' />
                                        </div>
                                        <div class='form-wrapper'>
                                            <label> Địa chỉ</label>
                                            <input class='form-item' name='province' />
                                        </div>
                                        <button class='button primary-button'>Thêm bến xe</button>
                                    </form>
                            `
                            },
                            {
                                title: 'Xóa bến xe',
                                id: 'tab-4',
                                render: `
                                    <form action='/vexepro/station/delete'>
                                        <div class='form-wrapper'>
                                            <label>Nhập id</label>
                                            <input class='form-item' name='id' />
                                        </div>
                                        <button class='button primary-button'>Xóa bến xe</button>
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
                    </script>;
                </div>
            </div>
        </div>
    </main>
</body>

</html>