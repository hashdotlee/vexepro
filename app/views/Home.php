<html>

<head>
    <title> Trang chủ </title>
    <link rel="stylesheet" href="/vexepro/app/views/Home.css" />
</head>

<body>
    <?php
    require_once _DIR_ROOT . '/app/views/CustomerNavbar.php';
    ?>
    <main>
        <div class="hero">
            <form action="/vexepro/trip/search">
                <div class="search-bar">
                    <div class="search-input">
                        <div class="search-item">
                            <label>Nơi xuất phát</label>
                            <select name="beginning" class="search-input-item">
                                <?php
                                foreach ($provinces as $province) {
                                    echo '<option value="' . $province . '">' . $province . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="search-item">
                            <label>Nơi đến</label>
                            <select name="destination" class="search-input-item">
                                <?php
                                foreach ($provinces as $province) {
                                    echo '<option value="' . $province . '">' . $province . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="search-item">
                            <label>Ngày đi</label>
                            <input type="date" name="start_date" class="search-input-item" />
                        </div>
                    </div>
                    <button class="search-button" type="submit"> Tìm chuyến</button>
                </div>
            </form>
        </div>
        <div class="container">
            <div class="show-title"> Tuyến đường phổ biến </div>
            <div class="show-wrapper">
                <?php
                foreach ($trips as $trip) {
                    printf("<a class='show-item' href='%s'>
                          <div class='show-img'>
                          <img src='https://storage.googleapis.com/vex-config/cms-tool/destination/images/5/img_hero.png?v1' alt='car'/>
                          </div>
                          <div class='show-desc'>
                          <div class='show-item-title'>%s - %s</div>
                          <div>Chỉ từ %s</div>
                          </div>
                          </a>
                          ", "/vexepro/trip/search?beginning=$trip->start_province&destination=$trip->end_province", $trip->start_province, $trip->end_province, $trip->price);
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>