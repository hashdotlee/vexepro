<html>

<head>
    <title> Tôi </title>
    <link rel="stylesheet" href="/vexepro/app/views/Home.css" />
    <link rel="stylesheet" href="/vexepro/app/views/Me.css" />
</head>

<body>
    <?php
    require_once _DIR_ROOT . '/app/views/CustomerNavbar.php';
    require_once _DIR_ROOT . '/app/views/Modal.php';
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
                        const ticket_status = {
                            'pending': 'Mới đặt',
                            'active': 'Kích hoạt',
                            'used': 'Đã sử dụng'
                        };
                        const tickets = [
                            <?php
                            $ownerName = $_SESSION['userObj']->name;
                            foreach ($tickets as $ticket) {
                            print("{
                                id: '$ticket->id',
                                start_place: '$ticket->start_station',
                                end_place: '$ticket->end_station',
                                price: '$ticket->price',
                                start_time: '$ticket->start_time',
                                est_time: '$ticket->est_time',
                                owner: '$ownerName',
                                agency_name: '$ticket->agency_name',
                                vehicle_type: '$ticket->vehicle_type',
                                status: '$ticket->status',
                                seat: '$ticket->seat',
                                trip_id: '$ticket->trip_id',
                            },");
                            }
                            $username = $_SESSION['userObj']->username;
                            $tel = $_SESSION['userObj']->tel;
                            $addr = $_SESSION['userObj']->address;
                            $email = $_SESSION['userObj']->email;
                            ?>
                        ]
                        const tabs = [{
                                title: 'Thông tin cá nhân',
                                id: 'tab-1',
                                render: `
                                    <div>
                                        <div class='form-wrapper'>
                                            <label>Tên người dùng</label>
                                            <input class='form-item' name='username' value='<?php echo $username?>'/>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Họ và tên</label>
                                            <input class='form-item' name='fullname' value='<?php echo $ownerName?>'/>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Số điện thoại</label>
                                            <input class='form-item' name='phone' value='<?php echo $tel?>'/>
                                        </div>
                                        <div class='form-wrapper'>
                                            <label>Địa chỉ</label>
                                            <input class='form-item' name='address' value='<?php echo $addr?>'/>
                                        </div>
                                    </div>
                                `
                            },
                            {
                                title: 'Vé mới',
                                id: 'tab-2',
                                render: `<div>
                                    ${(function fun(){
                                        let ct = '';
                                        tickets.filter(item => item.status === 'pending').forEach(item => {
                                            console.log(item);
                                            ct += ` <div class = 'ticket-item-wrapper'>
                                            <div class = 'ticket-id' style = 'margin-bottom: 8px'> No.${item.id} <span style='font-size: 12px;padding: 2px 4px; background:white; text-transform: uppercase; border-radius:5px; color:black'> ${ticket_status[item.status]}</span>
                                                <div class = 'ticket-content'>
                                                <div class = 'ticket-content-l'>
                                                <div style = 'font-size:18px' > 
                                                <b> Người mua: </b><i> ${item.owner}</i> 
                                                </div> 
                                                <div> 
                                                <b> Nhà xe: </b> ${item.agency_name}</div>
                                                </div> 
                                                <div class = 'ticket-content-r'> Giá vé: ${item.price / 1000}.000 đ </div></div> 
                                                <div class = 'ticket-datetime'>
                                                <div class = 'ticket-datetime-l' >
                                                <div> 
                                                <b> Điểm đi: </b> ${item.start_place}
                                                </div>-
                                                <div>
                                                <b> Điểm đến: </b> ${item.end_place}</div >
                                                </div>
                                                <div class = 'ticket-datetime-r'> <b> Thời gian: </b> ${item.start_time}</div >
                                                </div>
                                                <a href = '/vexepro/ticket/cancel?ticket_id=${item.id}&trip_id=${item.trip_id}' class = 'button' style = 'background: #FF7F7F; margin: 8px 0px; color: white'> Hủy vé </a>
                                                <p>
                                                <button class = 'button' type = '' style = 'background: green; margin: 8px 0px; color: white' onClick = 'showDialog(${item.id})'/>Yêu cầu kích hoạt </button> 
                                        </p> 
                                        </div>`
                                    });
                                    return ct;
                                    })()}
                                </div>
                                `
                            },
                            {
                                title: 'Vé đã kích hoạt',
                                id: 'tab-3',
                                render: ` <div> ${(function fun() {
                                    let ct = '';
                                    tickets.filter(item => item.status === 'active').forEach(item => {
                                        ct += `<div class='ticket-item-wrapper'>
                                                <div class='ticket-id' style='margin-bottom: 8px'>No.${item.id} <span style='font-size: 12px;padding: 2px 4px; background:green; text-transform: uppercase; border-radius:5px; color:white'>${ticket_status[item.status]}</span></div>    
                                                <div class='ticket-content'>
                                                    <div class='ticket-content-l'>
                                                        <div style='font-size:18px'><b>Người mua:</b><i> ${item.owner}</i></div>
                                                        <div><b>Nhà xe:</b> ${item.agency_name}</div>
                                                    </div>
                                                    <div class='ticket-content-r'>Giá vé: ${item.price/1000}.000đ</div>
                                                    </div>    
                                                <div class='ticket-datetime'>
                                                    <div class='ticket-datetime-l'>
                                                        <div><b> Điểm đi:</b> ${item.start_place}</div>
                                                        -
                                                        <div><b> Điểm đến:</b> ${item.end_place}</div>
                                                    </div>
                                                    <div class='ticket-datetime-r'><b>Thời gian:</b> ${item.start_time}</div>
                                                </div>    
                                        </div>`
                                    });
                                    return ct;
                                })()
                            } </div>
                            `
                            },
                            {
                                title: 'Vé đã dùng',
                                id: 'tab-4',
                                render: ` <div> ${
                                (function fun() {
                                    let ct = '';
                                    tickets.filter(item => item.status === 'used').forEach(item => {
                                        ct += `<div class='ticket-item-wrapper'>
                                                <div class='ticket-id' style='margin-bottom: 8px'>No.${item.id} <span style='font-size: 12px;padding: 2px 4px; background:gray; text-transform: uppercase; border-radius:5px; color:white'>${ticket_status[item.status]}</span></div>    
                                                <div class='ticket-content'>
                                                    <div class='ticket-content-l'>
                                                        <div style='font-size:18px'><b>Người mua:</b><i> ${item.owner}</i></div>
                                                        <div><b>Nhà xe:</b> ${item.agency_name}</div>
                                                    </div>
                                                    <div class='ticket-content-r'>Giá vé: ${item.price/1000}.000đ</div>
                                                    </div>    
                                                <div class='ticket-datetime'>
                                                    <div class='ticket-datetime-l'>
                                                        <div><b> Điểm đi:</b> ${item.start_place}</div>
                                                        -
                                                        <div><b> Điểm đến:</b> ${item.end_place}</div>
                                                    </div>
                                                    <div class='ticket-datetime-r'><b>Thời gian:</b> ${item.start_time}</div>
                                                </div>    
                                        </div>`
                                    });
                                    return ct;
                                })()
                            } </div>
                                `
                            },
                            {
                                title: 'Đăng xuất',
                                id: 'tab-6',
                                render: ` <div>
                                <a class = 'button danger-button'href = '/vexepro/user/logout' > Đăng xuất </a> </div>
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