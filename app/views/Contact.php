<html>

<head>
    <title> Liên hệ </title>
    <link rel="stylesheet" href="/vexepro/app/views/Home.css" />
    <link rel="stylesheet" href="/vexepro/app/views/Me.css" />
</head>

<body>
    <?php
    require_once _DIR_ROOT . '/app/views/CustomerNavbar.php';
    ?>
    <main>
        <?php
        if (isset($message) && $message != "") {
            printf("<script>alert(\"%s\")</script>", $message);
        }
        $message = ""
        ?>
        <div class="container" style="display: flex">
            <div class="card" style="display: flex; gap: 24px; width: 100%">
                <div style="flex: 0 0 30%">
                    <a href='/vexepro/complain/index' style="padding: 8px; border-radius: 8px;text-decoration: none; display: block;  color: black; width: 100%; margin-bottom: 12px; cursor: pointer; background: rgba(0,0,0,0.1)">Tạo yêu cầu mới</a>
                    <?php
                    $request_status = ['pending' => 'Đang chờ', 'resolved' => 'Đã xử lý'];
                    foreach ($complains as $c) {
                        printf("<a href='/vexepro/complain/detail?id=$c->id' style=\"text-decoration: none; display: block;  color: black; width: 100%%; padding: 8px; cursor:pointer;margin-bottom: 12px; border-radius:  8px; background: %s\">Số %d - %s - %s</a>", ($c->status == "pending") ? "lightgreen" : "rgba(0,0,0,0.1)", $c->id, $c->content, $request_status[$c->status]);
                    }
                    ?>
                </div>
                <div style="<?php echo isset($complain) ? 'display: none' : 'display: block' ?>; width: 100%">
                    <?php
                    $complain_subjects = ["account" => "Tài khoản", "agency" => "Về nhà xe", "system" => "Trang Web"];
                    $complain_type = ["bug" => "Thông báo lỗi", "complain" => "Khiếu nại", "contribute" => "Đóng góp ý kiến"];
                    ?>
                    <div style="font-size: 24px; font-weight: bold">Nhập thông tin hỗ trợ</div>
                    <p>Thông tin bạn cung cấp sẽ giúp chúng tôi cải thiện sản phẩm ngày càng hoàn thiện hơn!</p>
                    <form class='form-wrapper' action='/vexepro/complain/add_c' method='POST'>
                        <input style="visibility: hidden; display: none" name='user_id' value='<?php echo $_SESSION['userObj']->id ?>' />

                        <div>
                            <label>Tiêu đề</label>
                            <select class='form-item' name='topic'>
                                <?php
                                foreach ($complain_subjects as $key => $value) {
                                    printf("<option id=\"%s\">%s</option>", $key, $value);
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label>Loại yêu cầu</label>
                            <select class='form-item' name='type'>
                                <?php
                                foreach ($complain_type as $key => $value) {
                                    printf("<option id=\"%s\">%s</option>", $key, $value);
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label>Nội dung</label>
                            <textarea style='width: 100%' rows="5" name='content'></textarea>
                        </div>
                        <button type='submit' class='button primary-button' style='margin-top: 8px'>Gửi yêu cầu</button>
                    </form>
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
                                printf("<div style=\"text-align:right\">%s</div>", $m->content);
                            }
                            ?>
                        </div>

                        <div>
                            <form action="/vexepro/complain/add_m" method="POST">
                                <input style="visibility: hidden; display: none" name='user_id' value='<?php echo $_SESSION['userObj']->id ?>' />
                                <input style="visibility: hidden; display: none" name='complain_id' value='<?php echo $complain->id ?>' />
                                <textarea style="width: 100%; padding: 4px 8px; resize: vertical" autofocus="true" rows="4" name="content" placeholder="Nhập tin nhắn vào đây"></textarea>
                                <button style="max-width: max-content; padding: 8px 16px; margin-top: 8px">Gửi</button>
                            </form>
                        </div>

                </div>
            <?php } ?>
            </div>
        </div>

        </div>
    </main>
</body>

</html>