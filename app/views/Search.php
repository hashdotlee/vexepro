<html>

<head>
    <title> Tìm chuyến </title>
    <link rel="stylesheet" href="/vexepro/app/views/Home.css" />
    <link rel="stylesheet" href="/vexepro/app/views/Search.css" />
</head>

<body>
    <?php
    require_once _DIR_ROOT . '/app/views/CustomerNavbar.php';

    ?>

    <main>
        <?php
        if (array_key_exists("errorBookTicket", $_GET)) printf("<script>alert('%s')</script>", $_GET["errorBookTicket"]);
        ?>
        <div class="container">
            <div class="title">Tìm chuyến</div>
            <div class="wrapper">
                <div class="search-filter">
                    <div style="font-size: 18px; border-bottom: 1px solid rgba(0,0,0,0.15);  margin-bottom: 12px;padding-bottom: 12px "> Bộ lọc </div>
                    <form action="/vexepro/trip/search">
                        <div class="form-item">
                            <label>Nơi đi</label>
                            <select name="beginning" class='form-input'>
                                <?php
                                foreach ($provinces as $province) {
                                    if ($province == $_GET['beginning']) {
                                        echo '<option selected=\"true\" value="' . $province . '">' . $province . '</option>';
                                    } else {
                                        echo '<option value="' . $province . '">' . $province . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-item">
                            <label> Nơi đến</label>
                            <select name="destination" class="form-input">
                                <?php
                                foreach ($provinces as $province) {
                                    if ($province == $_GET['destination']) {
                                        echo '<option selected=\"true\" value="' . $province . '">' . $province . '</option>';
                                    } else {
                                        echo '<option value="' . $province . '">' . $province . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-item">
                            <label>Ngày đi</label>
                            <input type="date" name="start_date" class="form-input" value="<?php if (array_key_exists('start_date', $_GET)) echo $_GET['start_date'] ?>"></input>
                        </div>
                        <div class="form-item">
                            <label>Giá thấp nhất</label>
                            <input name="price_low" class="form-input" />
                        </div>
                        <div class="form-item">
                            <label>Giá cao nhất</label>
                            <input name="price_high" class="form-input" />
                        </div>
                        <button class='button primary-button' style='width: 100%'>Tìm kiếm</button>
                    </form>
                </div>
                <div class="search-content">
                    <?php

                    foreach ($trips as $trip) {
                        $unavailable = "";
                        foreach ($trip->tickets as $ticket) {
                            $unavailable .= $ticket['seat'];
                            $unavailable .= " ";
                        }
                        try {
                            $start_time = DateTime::createFromFormat('H:i:s', $trip->start_time_specific);
                            $est_time_interval = new DateInterval('PT' . $trip->est_hour . 'H' . $trip->est_minute . 'M');
                            $start_time_str = $start_time->format('H:i');
                            $end_time_str = $start_time->add($est_time_interval)->format('H:i');
                    ?>
                            <div id='<?php echo $trip->id ?>' class='search-item-wrapper'>
                                <div class='search-item'>
                                    <div class='search-img-wrapper'>
                                        <img class='search-img' src='https://static.vexere.com/production/images/1663578798814.jpeg?w=250&h=250' />
                                    </div>
                                    <div class='search-item-content'>
                                        <div class='search-title'>
                                            <div class='agency-name'><?php echo $trip->agency_name ?></div>
                                            <div class='price'><?php echo ($trip->price / 1000) ?>.000đ</div>
                                        </div>
                                        <div class='vehicle-type'><?php echo $trip->vehicle_type ?></div>
                                        <div class='search-desc'>
                                            <div class='search-places'>
                                                <div class='start'>
                                                    <div class='start-time'><?php echo $start_time_str ?></div>
                                                    <div class='start-place'><?php echo $trip->start_station ?></div>
                                                </div>
                                                <div class='estimate'><?php echo date('H:i', strtotime($trip->est_time)) ?></div>
                                                <div class='end'>
                                                    <div class='end-time'><?php echo $end_time_str ?></div>
                                                    <div class='end-place'><?php echo $trip->end_station ?></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class='remain'>Còn <?php echo $trip->remaining_slots ?> chỗ trống</div>
                                                <button style='margin-top: 12px' onclick='onShow(<?php echo "$trip->id, $trip->row, $trip->level, $trip->line, \"$unavailable\", \"$trip->agency_tel\", \"$trip->agency_bank_number\", \"$trip->agency_bank_name\", \"$trip->start_station\", \"$trip->end_station\", \"$trip->agency_name\", $trip->price, \"$start_time_str\", \"$end_time_str\"" ?>)'>Chọn chuyến</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        } catch (Exception $e) {
                            echo "Cannot convert datetime";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <script type='text/javascript'>
        let current_id = 0;

        function confirm_h(start, end, start_time, end_time, agency_name, phone, bank_name, bank_number, price, tickets) {
            let row = document.forms["ticket-book"]['row'].value;
            let level = document.forms["ticket-book"]['level'].value;
            let seat = document.forms["ticket-book"]['seat'].value;
            if (tickets.split(" ").includes(row + level + seat)) {
                alert("Chỗ đã có người đặt, quý khách vui lòng đặt lại chỗ khác!");
                return false;
            }
            let text = `
                    Xác nhận!
                    Thông tin vé đã đặt:
                    Điểm đi: ${start}
                    Điểm đến: ${end}
                    Thời gian: ${start_time} - ${end_time}
                    Giá vé: ${price} VNĐ
                    Thông tin nhà xe:
                    ${agency_name}
                    SĐT: ${phone}
                    Số tài khoản: ${bank_name} - ${bank_number}
                    Vui lòng thanh toán qua số tài khoản và gửi yêu cầu kích hoạt vé hoặc gọi vào số điện thoại để biết thêm chi tiết!
            `;
            if (confirm(text)) {
                alert("Xác nhận thành công!");
                return true;
            }

        }

        function onShow(id, row, level, line, tickets, phone, bank_number, bank_name, start, end, agency_name, price, start_time, end_time) {
            let form = document.createElement('div');

            form.innerHTML = `
                    <form name='ticket-book' class='form-wrapper' action='/vexepro/ticket/book' onsubmit='return confirm_h(\"${start}\", \"${end}\", \"${start_time}\", \"${end_time}\", \"${agency_name}\", \"${phone}\", \"${bank_name}\", \"${bank_number}\", \"${price}\", \"${tickets}\", this)'>
                        <div style='display:flex; align-items: center;gap:8px'>
                            <div class='form-item'>
                                <input name='trip_id' value='${id}' style='visibility:hidden;display:none'/>
                                <label>Số hàng</label>
                                <select class='form-input' name='row'>
                                ${(function fun(){
                                var options = '';
                                for(let i = 0; i<row; i++){
                                options += '<option value=\''+ String.fromCharCode(65+i) + '\'>' + String.fromCharCode(65+i) + '</option>';
                                }
                                return options;
                                })()}
                                </select>
                                </div>
                                <div class='form-item'>
                                <label>Số tầng</label>
                                <select class='form-input' name='level'>
                                ${(function fun(){
                                var options = '';
                                for(let i = 1; i<=level; i++){
                                options += '<option value=\''+i+'\'>'+ i +'</option>';
                                }
                                return options;
                                })()}
                                </select>
                                </div>
                                <div class='form-item'>
                                <label>Số ghế</label>
                                <select class='form-input' name='seat'>
                                ${(function fun(){
                                var options = '';
                                for(let i = 1; i<=line; i++){
                                options += '<option value=\''+i+'\'>'+ i + '</option>';
                                }
                                return options;
                                })()}
                                </select>
                            </div>
                        </div>
                        <div>
                            Các vị trí đã có người đặt: ${tickets.split(' ').join(', ')}
                        </div>
                        <div style='margin-top: 15px; font-size: 14px; opacity: 60%'>
                            Vui lòng liên hệ qua số điện thoại: ${phone}
                        </div>
                        <div style='font-size: 14px; opacity: 60%'>
                            Thông tin chuyển khoản: ${bank_name + ' - ' + bank_number}
                        </div>
                        <div style='display:flex;justify-content:end'>
                            <button type='submit' class='button'>Đặt vé</button>
                        </div>
                        </form>
            `

            let newElement = document.getElementById(String(id));
            newElement.appendChild(form);
            if (current_id !== 0) {
                let oldElement = document.getElementById(String(current_id));
                oldElement.removeChild(oldElement.lastChild);
            }
            current_id = id;
        }
    </script>
</body>

</html>