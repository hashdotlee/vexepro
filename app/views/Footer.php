<footer style="width: 100vw;max-width: 1000px; margin:0 auto">
        <div class="company-desc" style="display:flex; justify-content: space-between; flex-wrap: wrap; color: rgba(0,0,0,0.7); font-size: 14px;">
            <div class="trips" style="padding: 16px 16px">
                <div style="font-size:16; font-weight: bold; margin-bottom: 8px; text-align:left">Danh sách chuyến</div>
                <?php
                    foreach($footer['trips'] as $index => $trip){
                        if($index <= 10)
                        printf("<div style='text-align:left; margin: 4px 0px'>Chuyến <b>%s</b> đi <b>%s</b></div>", $trip->start_station, $trip->end_station);
                    }
                ?>
            </div>
            <div class="stations" style="padding: 16px 16px">
                <div style="font-size:16; font-weight: bold; margin-bottom: 8px; text-align:left">Danh sách bến</div>
                <?php
                    foreach($footer['stations'] as $index => $station){
                        if($index <= 10)
                        printf("<div style='text-align:left; margin: 4px 0px'>%s</div>", $station->name);
                    }
                ?>
            </div>
            <div class="agencies" style="padding: 16px 16px">
                <div style="font-size:16; font-weight: bold; margin-bottom: 8px; text-align:left">Danh sách nhà xe</div>
                <?php
                    foreach($footer['agencies'] as $index => $agency){
                        if($index <= 10)
                        printf("<div style='text-align:left; margin: 4px 0px'>Nhà xe %s</div>", $agency->name);
                    }
                ?>
            </div>
        </div>
        <div class="company-name" style="font-size:18; font-weight: bold; padding-top: 16px; border-top: 1px solid rgba(0,0,0,0.15);margin-top: 16px">Công ty TNHH Thương Mại Dịch Vụ Vexepro
                </div>
                <pre>Địa chỉ đăng ký kinh doanh: Việt Nam
Địa chỉ: Việt Nam
Bản quyền © 2023 thuộc về Vexepro</pre>
</footer>