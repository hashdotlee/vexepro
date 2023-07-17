<html>
    <head>
        <title> Quản lý vé </title>
        <link rel="stylesheet" href="/vexepro/app/views/Home.css"/>
        <link rel="stylesheet" href="/vexepro/app/views/Me.css"/>
        <link rel="stylesheet" href="/vexepro/app/views/TripMana.css"/>
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
                        <?php
                        $ticket_status = ["pending" => "Mới đặt", "active" => "Kích hoạt", "canceled" => "Hủy", "used" => "Đã sử dụng"];
                        print("<script type='text/javascript'>
                            const tabs = [
                                {
                                    title: 'Danh sách vé',
                                    id: 'tab-1',
                                    render: `
                                    <div>
                                    <form action='/vexepro/ticket/manage' method='POST'>
                                        <div style='margin-bottom: 8px'>
                                            <label style='display: inline-block'>Tìm kiếm theo ID: </label>
                                            <input class='form-item' name='id' placeholder='Nhập ID để tìm kiếm'/>
                                        </div>
                                        <button class='button' type='submit'> Tìm kiếm </button>
                                    </form>
                                    <div class='table-wrapper'>
                                    <table>
                                    <tr>
                                    <th> Mã vé</th>
                                    <th>Mã người dùng</th>
                                    <th> Mã chuyến</th>
                                    <th> Trạng thái</th>
                                    </tr>
                                    ");
                                    foreach($tickets as $ticket){
                                        printf("
                                        <tr>
                                    <td>%d</td>
                                    <td>%d</td>
                                    <td>%d</td>
                                    <td>%s</td>
                                    </tr>
                                        ", $ticket->id, $ticket->user_id, $ticket->trip_id, $ticket_status[$ticket->status]);
                                    }
                                    print("
                                    </table>
                                    </div>
                                    </div>
                                    `
                                },
                                {
                                    title: 'Cập nhật trạng thái',
                                    id: 'tab-3',
                                    render: `
                                    <form action='/vexepro/ticket/update'>
                                        <div class='form-wrapper'>
                                            <label>Nhập id</label>
                                            <input class='form-item' name='id'/>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Trạng thái</label>
                                            <select class='form-item' name='status'>
                                            ");
                                            
                                            foreach($ticket_status as $key => $value){
                                                printf("<option value='%s'>%s</option>", $key, $value);
                                            }
                                            print("
                                            </select>
                                        </div>
                        <button class='button primary-button'>Cập nhật</button>
                                    </form>
                                    `
                                },
                            ];
                            let activeTab = tabs[0].id;
                            let menu = document.getElementById('tab-menu');
                            let content = document.getElementById('tab-content');
                            content.innerHTML = tabs[0].render;
                            tabs.forEach(item => {
                                let element = document.createElement('div');
                                element.classList.add('tab-item');
                                element.id = item.id;
                                element.onclick=function(){onChangeTab(item)};
                                element.innerText = item.title;
                                menu.appendChild(element);
                            })
                            document.getElementById(activeTab).classList.add('active');
                            function onChangeTab(tab){
                                content.innerHTML = tab.render;
                                document.getElementById(activeTab).classList.remove('active');
                                document.getElementById(tab.id).classList.add('active');
                                activeTab = tab.id;
                            }
                        </script>");

                        ?>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>

