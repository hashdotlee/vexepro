<html>

<head>
    <title> Quản lý xe </title>
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
                    <div class="col-l border-r" id="tab-menu">
                    </div>
                    <div class="col-r" id="tab-content">
                    </div>
                    <?php
                    if (array_key_exists('vehicleManage', $error)) {
                        $err = $error["vehicleManage"];
                        print("<script type=\"text/javascript\">alert('$err')</script>");
                    }
                    if (array_key_exists('vehicleUpdate', $error)) {
                        $err = $error["vehicleUpdate"];
                        print("<script type=\"text/javascript\">alert('$err')</script>");
                    }
                    ?>
                    <script type='text/javascript'>
                        const tabs = [{
                                title: 'Danh sách xe',
                                id: 'tab-1',
                                render: `
                                    <div>
                                    <form action='/vexepro/vehicle/manage' method='GET'>
                                        <div style='margin-bottom: 8px'>
                                            <label style='display: inline-block'>Tìm kiếm: </label>
                                            <input class='form-item' name='search' placeholder='Nhập ID, tên nhà xe, loại xe để tìm kiếm'/>
                                        </div>
                                        <button class='button' type='submit'> Tìm kiếm </button>
                                    </form>
                                        <table>
                                            <tr>
                                                <th>Mã xe</th>
                                                <th>Tên nhà xe</th>
                                                <th>Loại xe</th>
                                                <th>Số hàng</th>
                                                <th>Số tầng</th>
                                                <th>Số dãy</th>
                                            </tr>
                                            
                   <?php foreach ($vehicles as $vehicle) {
                        printf(
                            "
                                                <tr>
                                                <td>%d</td>
                                                <td>%s</td>
                                                <td>%s</td>
                                                <td>%d</td>
                                                <td>%d</td>
                                                <td>%d</td>
                                                </tr>
                                                ",
                            $vehicle->id,
                            $vehicle->agency_name,
                            $vehicle->type,
                            $vehicle->row,
                            $vehicle->level,
                            $vehicle->line
                        );
                    } ?>
                    
                                        </table>
                                    </div>
                                    `
                            },
                            {
                                title: 'Thêm xe',
                                id: 'tab-2',
                                render: `
                                    <form action='/vexepro/vehicle/add'>
                                        <div class='form-wrapper'>
                                            <label>Chọn nhà xe</label>
                                            <select class='form-item' name='agency'>
                                          
                  <?php foreach ($agencyMap as $id => $name) {
                        print("<option value=\'{$id}\'>{$name}</option>");
                    } ?>

                  
                                            </select>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Chọn loại xe</label>
                                            
                                            <select class='form-item' name='type'>
                                          
                                            <?php foreach ($vehicleTypes as $t) {
                                                print("<option value='$t->id'>$t->type</option>");
                                            } ?>
                   
                                            </select>
                                        </div>
                                        <div class='form-wrapper'>
                                        <label>Biển số xe</label>
                                        
                                        <input name='plate_num' class='form-item' placeholder='Biển số xe'/>
                                    </div>
                                        <button class='button primary-button'>Thêm xe</button>
                                    </form>
                                    `
                            },
                            {
                                title: 'Danh sách loại xe',
                                id: 'tab-3',
                                render: `
                                    <div>
                                        <div style='margin-bottom: 8px'>
                                            <label style='display: inline-block'>Tìm kiếm theo ID: </label>
                                            <input class='form-item' name='trip_id' placeholder='Nhập ID để tìm kiếm'/>
                                        </div>
                                        <table>
                                            <tr>
                                                <th>Mã loại</th>
                                                <th>Tên loại</th>
                                                <th>Số hàng</th>
                                                <th>Số tầng</th>
                                                <th>Số dãy</th>
                                            </tr>
                                          
                    <?php foreach ($vehicleTypes as $t) {
                        print("
                                                <tr>
                                                <td>$t->id</td>
                                                <td>$t->type</td>
                                                <td>$t->row</td>
                                                <td>$t->level</td>
                                                <td>$t->line</td>
                                                </tr>
                                                ");
                    } ?>
                    
                                        </table>
                                    </div>
                                    `
                            },
                            {
                                title: 'Thêm loại xe',
                                id: 'tab-4',
                                render: `
                                    <form action='/vexepro/vehicletype/add'>
                                        <div class='form-wrapper'>
                                            <label>Nhập loại xe</label>
                                            <input class='form-item' name='type'></input>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Số tầng</label>
                                            <input class='form-item' name='level'></input>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Số hàng</label>
                                            <input class='form-item' name='row'></input>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Số dãy</label>
                                            <input class='form-item' name='line'></input>
                                        </div>
                                        <button class='button primary-button'>Thêm xe</button>
                                    </form>
                                    `
                            },
                            {
                                title: 'Sửa thông tin xe',
                                id: 'tab-5',
                                render: `
                                    <form action='/vexepro/vehicle/update'>
                                        <div class='form-wrapper'>
                                            <label>Nhập id</label>
                                            <input class='form-item' name='id'/>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Chọn nhà xe</label>
                                            <select class='form-item' name='agency_id'>
                                            
                   <?php foreach ($agencyMap as $id => $name) {
                        print("<option value=\'{$id}\'>{$name}</option>");
                    } ?>
                   
                                            </select>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Chọn loại xe</label>
                                            <select class='form-item' name='type_id'>
                                            
                    <?php foreach ($vehicleTypes as $t) {
                        print("<option value='$t->id'>$t->type</option>");
                    } ?>
                    
                                            </select>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Biển số xe</label>
                                            <input class='form-item' name='plate_num'/>
                                        </div>
                                        <button class='button primary-button'>Sửa chuyến</button>
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