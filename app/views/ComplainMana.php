<html>

<head>
    <title> Quản lý khiếu nại </title>
    <link rel="stylesheet" href="/vexepro/app/views/Home.css" />
    <link rel="stylesheet" href="/vexepro/app/views/Me.css" />
    <link rel="stylesheet" href="/vexepro/app/views/TripMana.css" />
    <link rel="stylesheet" href="/vexepro/app/views/VehicleMana.css" />
</head>

<body>
    <?php
    require_once _DIR_ROOT . '/app/views/AdminNavbar.php';
    ?>
    <main>
        <div class="container">
            <div class="card">
                <div class="row" id="row">
                    <div class="col-l border-r" id="tab-menu"  style="<?php echo isset($complain) ? 'display: none' : 'display: block' ?>; width: 100%">
                    </div>
                    <div class="col-r" id="tab-content">
                        <div id='tab-wrapper' style="<?php echo isset($complain) ? 'display: none' : 'display: block' ?>; width: 100%">

                        </div>
                        <div style="<?php echo isset($complain) ? 'display: flex; flex-direction: column; gap:8px; width: 100%' : 'display: none' ?>">
                            <?php
                            if (isset($complain)) {
                            ?>
                                <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
                                    <?php
                                    echo $complain->content;
                                    ?>
                                </div>
                                <div style="width: 100%; min-height: 200px; border: 1px solid rgba(0,0,0,0.15); padding: 16px">
                                    <?php
                                    foreach ($messages as $m) {
                                        printf("<div style=\"text-align:%s\">%s</div>", $m->role=='admin' ? 'right' : 'left',  $m->content);
                                    }
                                    ?>
                                </div>

                                <div>
                                    <form action="/vexepro/complain/add_m_admin" method="POST">
                                        <input style="visibility: hidden; display: none" name='user_id' value='<?php echo $_SESSION['adminObj']->id ?>' />
                                        <input style="visibility: hidden; display: none" name='complain_id' value='<?php echo $complain->id ?>' />
                                        <textarea style="width: 100%; padding: 4px 8px; resize: vertical" autofocus="true" rows="4" name="content" placeholder="Nhập tin nhắn vào đây"></textarea>
                                        <button style="max-width: max-content; padding: 8px 16px; margin-top: 8px">Gửi</button>
                                    </form>
                                </div>

                        </div>
                    <?php } ?>
                    </div>
                    <div>

                    </div>
                </div>
                <?php
                $request_status = ['pending' => 'Đang chờ', 'resolved' => 'Đã xử lý'];
                ?>
                <script type='text/javascript'>
                    const tabs = [{
                            title: 'Danh sách khiếu nại',
                            id: 'tab-1',
                            url: "/vexepro/complain/index",
                            render: `
                                    <div>
                                    <form action='/vexepro/complain/manage' method='POST'>
                                    <div style='margin-bottom: 8px'>
                                        <label style='display: inline-block'>Tìm kiếm theo ID: </label>
                                        <input class='form-item' name='id' placeholder='Nhập ID để tìm kiếm'/>
                                    </div>
                                    <button class='button' type='submit'> Tìm kiếm </button>
                                    </form>
                                        <table>
                                            <tr>
                                                <th>Mã khiếu nại</th>
                                                <th>Mã người dùng</th>
                                                <th>Chủ đề</th>
                                                <th>Loại</th>
                                                <th>Nội dung</th>
                                                <th>Trạng thái</th>
                                                <th></th>
                                            </tr>
                                            
                                           <?php foreach ($complains as $complain) {
                                                printf(
                                                    "
                                                <tr>
                                                <td>%d</td>
                                                <td>%d</td>
                                                <td>%s</td>
                                                <td>%s</td>
                                                <td>%s</td>
                                                <td>%s</td>
                                                <td>%s</td>
                                                </tr>
                                                ",
                                                    $complain->id,
                                                    $complain->user_id,
                                                    $complain->topic,
                                                    $complain->type,
                                                    $complain->content,
                                                    $complain->status,
                                                    "<a href='/vexepro/complain/detail_admin?id=$complain->id'>Trả lời</a>"
                                                );
                                            } ?>
                                            
                                        </table>
                                    </div>
                                    `
                        },
                        {
                            title: 'Cập nhật trạng thái',
                            id: 'tab-5',
                            url: "/vexepro/complain/index",
                            render: `
                                    <form action='/vexepro/vehicle/update'>
                                        <div class='form-wrapper'>
                                            <label>Nhập id</label>
                                            <input class='form-item' name='id'/>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Chọn trạng thái</label>
                                            <select class='form-item' name='status'>
                                            
                                           <?php foreach($request_status as $key => $value){
                                                print("<option value=\'{$key}\'>{$value}</option>");
                                            }
                                            ?>
                                            </select>
                                        </div>
                                        <button class='button primary-button'>Sửa chuyến</button>
                                    </form>
                                    `
                        }
                    ];
                    let activeTab = tabs[0].id;
                    let menu = document.getElementById('tab-menu');
                    let content = document.getElementById('tab-wrapper');
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