<?php
class TripDao
{
    public static function search_2(string $search): array
    {
        $conn = Connection::get();

        $sql = 'SELECT t.id id, start_time, vehicle_id, HOUR(est_time) est_hour, MINUTE(est_time) est_minute,'
            . ' time(start_time) start_time_specific, est_time, remaining_slots, price, plate_num, a.name agency_name, a.tel agency_tel, a.bank_number agency_bank_number, a.bank_name agency_bank_name,'
            . 'vt.`type` vehicle_type, `row`, `level`, `line`, s1.`name` start_station, s1.province start_province,'
            . ' s2.`name` end_station, s2.province end_province FROM trips t'
            . ' JOIN vehicles v ON t.vehicle_id = v.id'
            . ' JOIN agencies a ON v.agency_id = a.id'
            . ' JOIN vehicle_types vt ON v.type_id = vt.id'
            . ' JOIN stations s1 ON t.station_id_start = s1.id'
            . ' JOIN stations s2 ON t.station_id_end = s2.id ';
        if ($search)
            $sql = $sql
                . ' WHERE t.id LIKE ' . '\'%' . $search . '%\''
                . ' OR v.id LIKE ' . '\'%' . $search . '%\''
                . ' OR s1.`name` LIKE ' . '\'%' . $search . '%\''
                . ' OR s2.`name` LIKE' . '\'%' . $search . '%\'';
        $sql = $sql . 'ORDER BY t.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public static function search(array $filter): array
    {
        $conn = Connection::get();

        $sql = 'SELECT t.id id, start_time, HOUR(est_time) est_hour, MINUTE(est_time) est_minute,'
            . ' time(start_time) start_time_specific, est_time, remaining_slots, price, plate_num, a.name agency_name, a.tel agency_tel, a.bank_number agency_bank_number, a.bank_name agency_bank_name,'
            . 'vt.`type` vehicle_type, `row`, `level`, `line`, s1.`name` start_station, s1.province start_province,'
            . ' s2.`name` end_station, s2.province end_province FROM trips t'
            . ' JOIN vehicles v ON t.vehicle_id = v.id'
            . ' JOIN agencies a ON v.agency_id = a.id'
            . ' JOIN vehicle_types vt ON v.type_id = vt.id'
            . ' JOIN stations s1 ON t.station_id_start = s1.id'
            . ' JOIN stations s2 ON t.station_id_end = s2.id ';

        if (array_key_exists("beginning", $filter) && $filter['beginning'] != '') {
            $sql = $sql . ' WHERE s1.province =' . '"' . $filter["beginning"] . '"';
        }
        if (array_key_exists("destination", $filter) && $filter['destination'] != '') {
            $sql = $sql . ' AND s2.province =' . '"' . $filter["destination"] . '"';
        }
        if (array_key_exists("price_low", $filter) && $filter['price_low'] != '') {
            $sql = $sql . ' AND price >= ' . $filter["price_low"];
        }
        if (array_key_exists("price_high", $filter) && $filter['price_high'] != '') {
            $sql = $sql . ' AND price <= ' . $filter["price_high"];
        }
        if (array_key_exists("start_date", $filter) && $filter['start_date'] != '') {
            $sql = $sql . ' AND DATE(start_time) =' . '"' . $filter["start_date"]. '"';
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getUnavailableSeats($tripID): array
    {
        $conn = Connection::get();

        $sql = "SELECT seat FROM tickets ti"
            . " JOIN trips t ON ti.trip_id=t.id"
            . " WHERE t.id = ? AND status = 'active'";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$tripID]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getAllWithDetail(): array
    {
        $conn = Connection::get();

        $sql = 'SELECT t.id id, start_time, vehicle_id,'
            . ' est_time, remaining_slots, price, plate_num, a.name agency_name,'
            . ' vt.`type` vehicle_type, `row`, `level`, `line`, s1.`name` start_station, s1.province start_province,'
            . ' s2.`name` end_station, s2.province end_province FROM trips t'
            . ' JOIN vehicles v ON t.vehicle_id = v.id'
            . ' JOIN agencies a ON v.agency_id = a.id'
            . ' JOIN vehicle_types vt ON v.type_id = vt.id'
            . ' JOIN stations s1 ON t.station_id_start = s1.id'
            . ' JOIN stations s2 ON t.station_id_end = s2.id ORDER BY t.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public static function getAllPopularWithDetail(): array
    {
        $conn = Connection::get();

        $sql = 'SELECT t.id id, COUNT(ti.id) num_ticket, start_time, vehicle_id,'
            . ' est_time, remaining_slots, price, plate_num, a.name agency_name,'
            . ' vt.`type` vehicle_type, `row`, `level`, `line`, s1.`name` start_station, s1.province start_province,'
            . ' s2.`name` end_station, s2.province end_province FROM trips t'
            . ' JOIN vehicles v ON t.vehicle_id = v.id'
            . ' JOIN agencies a ON v.agency_id = a.id'
            . ' JOIN vehicle_types vt ON v.type_id = vt.id'
            . ' JOIN tickets ti ON ti.trip_id= t.id'
            . ' JOIN stations s1 ON t.station_id_start = s1.id'
            . ' JOIN stations s2 ON t.station_id_end = s2.id'
            . ' GROUP BY t.id'
            . ' ORDER BY num_ticket DESC'
            . ' LIMIT 4';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public static function getAllWithDetailById(int $trip_id): array
    {
        $conn = Connection::get();

        $sql = 'SELECT t.id id, start_time, vehicle_id,'
            . ' est_time, remaining_slots, price, plate_num, a.name agency_name,'
            . ' vt.`type` vehicle_type, `row`, `level`, `line`, s1.`name` start_station, s1.province start_province,'
            . ' s2.`name` end_station, s2.province end_province FROM trips t'
            . ' JOIN vehicles v ON t.vehicle_id = v.id'
            . ' JOIN agencies a ON v.agency_id = a.id'
            . ' JOIN vehicle_types vt ON v.type_id = vt.id'
            . ' JOIN stations s1 ON t.station_id_start = s1.id'
            . ' JOIN stations s2 ON t.station_id_end = s2.id WHERE t.id=? ORDER BY t.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$trip_id]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
