<?php
define('_DIR_ROOT', 'C:/xampp/htdocs/vexepro');
require_once _DIR_ROOT. '/configs/database.php';
require_once _DIR_ROOT. '/core/Database.php';
require_once _DIR_ROOT. '/core/Connection.php';
require_once _DIR_ROOT. '/core/SqlClauses.php';
require_once _DIR_ROOT. '/core/BaseSqlBuilder.php';
require_once _DIR_ROOT. '/core/MySqlBuilder.php';
require_once _DIR_ROOT. '/app/services/TripService.php';
require_once _DIR_ROOT. '/app/utils/helper.php';

function get_ids(string $table_name) : array {
    $objs = Database::getAll($table_name);
    $ids = [];

    foreach ($objs as $obj) {
        $ids[] = $obj->id;
    }

    return $ids;
}

function genArr(int $n) : array {
    $arr = [];
    for ($i = 1; $i <= $n; $i++) {
        $arr[] = $i;
    }
    return $arr;
}

function random_phone_number() : string {
    $tel = '09';
    for ($i = 0; $i < 8; $i++) {
        $tel .= rand(0, 9);
    }
    return $tel;
}

function random_bank_number() : string {
    $number = '';
    for ($i = 0; $i < 10; $i++) {
        $number .= rand(0, 9);
    }
    return $number;
}

function random_plate_number() : string {
    $prefix = rand(29, 33) . chr(rand(65, 70));
    return $prefix . '-' . rand(100, 999) . '.' . rand(10, 99);
}

function reset_AI(string $table_name) : void {
    $conn = Connection::get();

    $sql = "ALTER TABLE ".$table_name." AUTO_INCREMENT = 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function reset_all_AI() : void {
    reset_AI('agencies');
    reset_AI('stations');
    reset_AI('vehicle_types');
    reset_AI('vehicles');
    reset_AI('users');
    reset_AI('trips');
    reset_AI('tickets');
}

function agency_seed() : void {
    $conn = Connection::get();

    $sql = "INSERT INTO agencies(name, tel, bank_number, bank_name) VALUES 
         ('Nhà xe Xuân Truyền', '".random_phone_number()."', '".random_bank_number()."', 'BIDV'),
         ('Nhà xe Hưng Lonng', '".random_phone_number()."', '".random_bank_number()."', 'BIDV'),
         ('Nhà xe Cố Hương', '".random_phone_number()."', '".random_bank_number()."', 'VPBank')";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function station_seed() : void {
    $conn = Connection::get();

    $sql = "INSERT INTO stations(`name`, province) VALUES 
         ('Bến xe Nước Ngầm', 'Hà Nội'), 
         ('Bến xe Giáp Bát', 'Hà Nội'), 
         ('Bến xe trung tâm Đà Nẵng', 'Đà Nẵng'), 
         ('Bến xe Đức Long', 'Đà Nẵng'), 
         ('Bến xe Miền Tây', 'TP. Hồ Chí Minh'), 
         ('Bến xe Miền Đông', 'TP. Hồ Chí Minh')";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function vehicle_type_seed() : void {
    $conn = Connection::get();

    $sql = "INSERT INTO vehicle_types(`type`, `row`, `level`, `line`) VALUES 
          ('Giường nằm 30 chỗ',3,2,5),
          ('Limousine giường phòng 30 chỗ',3,2,5),
          ('Limousine 20 Giường Vip (có WC)',2,2,5)";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function vehicle_seed() : void {
    for ($agency_id = 1; $agency_id <= 3; $agency_id++) {
        for ($vehicle_type = 1; $vehicle_type <= 3; $vehicle_type++) {
            $nVehicles = rand(1, 4);
            for ($i = 0; $i < $nVehicles; $i++) {
                $data = [];
                $data['agency_id'] = $agency_id;
                $data['type_id'] = $vehicle_type;
                $data['plate_num'] = random_plate_number();
                Database::add('vehicles', $data);
            }
        }
    }
}

function trip_seed(int $n) : void {
    $conn = Connection::get();

    $sql = "SELECT COUNT(*) FROM vehicles";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $nVehicles = $stmt->fetch(PDO::FETCH_NUM)[0];
    $slots = [1, 30, 30, 20];
    $station_ids = get_ids('stations');

    for ($i = 0; $i < $n; $i++) {
        shuffle($station_ids);
        $station_id_start = $station_ids[0];
        $station_id_end = $station_ids[1];
        $vehicleID = rand(1, $nVehicles);

        $vehicle = Database::get('vehicles', 'id', '=', $vehicleID)[0];

        $data['remaining_slots'] = $slots[$vehicle->type_id];
        $data['station_id_start'] = $station_id_start;
        $data['station_id_end'] = $station_id_end;
        $data['vehicle_id'] = $vehicleID;
        $data['start_time'] = '2023:05:' . rand(1, 30) . ' ' . rand(0, 23) . ':' . (rand(0, 1) * 30) . ':00';
        $data['est_time'] = rand(1, 5) . ':' . (rand(0, 1) * 30) . ':00';
        $data['price'] = rand(20, 50) * 10000;
        Database::add('trips', $data);
    }
}

function user_seed() : void {
    $names = ['loc', 'duc', 'anh', 'an', 'long', 'hung', 'phuong', 'nhi', 'huyen', 'trang'];
    $addresses = ['Quảng Bình', 'Hà Tĩnh', 'Thanh Hóa', 'Nam Đinh', 'Đà Nẵng', 'Hà Nội', 'Huế', 'Nha Trang', 'Hải Phòng'];

    foreach ($names as $name) {
        $data = [];
        $data['username'] = $name;
        $data['password'] = password_hash('123', PASSWORD_BCRYPT);
        $data['name'] = ucfirst($name);
        $data['dob'] = rand(1990, 2005).':'.rand(1, 12).':'.rand(1, 28);
        $data['tel'] = random_phone_number();
        $data['email'] = $name . '@email.com';
        shuffle($addresses);
        $data['address'] = $addresses[0];
        $data['role'] = 'customer';

        Database::add('users', $data);
    }
}

function ticket_seed($nTrips) : void {
    $tripService = new TripService();
    $conn = Connection::get();
    $trips = Database::getAll('trips');
    shuffle($trips);
    $userArr = genArr(10);

    for ($i = 0; $i < $nTrips; $i++) {
        $nTickets = rand(3, 5);
        shuffle($userArr);

        $sql = 'SELECT vt.`row` as `row`, vt.`level` as `level`, vt.`line` as line FROM trips t'
            .' JOIN vehicles v ON t.vehicle_id = v.id'
            .' JOIN vehicle_types vt ON v.type_id = vt.id'
            .' WHERE t.id = ?';

        $stmt = $conn->prepare($sql);
        $stmt->execute([$trips[$i]->id]);

        $vData = $stmt->fetchAll()[0];
        $nSeats = $vData['row'] * $vData['level'] * $vData['line'];
        $seatsInt = genArr($nSeats);
        shuffle($seatsInt);
        $tripService->decreaseRemainingSlots($trips[$i]->id, $nTickets);

        for ($j = 0; $j < $nTickets; $j++) {
            $data = [];
            $data['user_id'] = $userArr[rand(0, 9)];
            $data['trip_id'] = $trips[$i]->id;
            $data['status'] = 'active';
            $data['seat'] = intToSeat($seatsInt[$j], $vData['row'], $vData['level'], $vData['line']);
            Database::add('tickets', $data);
        }
    }
}

function seed_all() : void {
    $nTrips = 200;

    reset_all_AI();

    agency_seed();
    station_seed();
    vehicle_type_seed();
    vehicle_seed();
    user_seed();
    trip_seed($nTrips);
    ticket_seed($nTrips);
}

echo 'Seeding...    ';

//user_seed();
//trip_seed(30);
//ticket_seed(20);

//vehicle_seed();
//trip_seed(10);
seed_all();

echo 'Done!';

