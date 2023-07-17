<?php
class TicketDao {
    public static function getByUserID(int $uid) : array {
        $conn = Connection::get();

        $sql = 'SELECT u.id, ti.id id, seat, status, start_time, trip_id, est_time, remaining_slots, price, plate_num, a.name agency_name,'
            .'vt.`type` vehicle_type, `row`, `level`, s1.`name` start_station, s1.province start_province,'
            .' s2.`name` end_station, s2.province end_province FROM tickets ti'
            .' JOIN users u ON ti.user_id = u.id'
            .' JOIN trips t ON ti.trip_id = t.id'
            .' JOIN vehicles v ON t.vehicle_id = v.id'
            .' JOIN agencies a ON v.agency_id = a.id'
            .' JOIN vehicle_types vt ON v.type_id = vt.id'
            .' JOIN stations s1 ON t.station_id_start = s1.id'
            .' JOIN stations s2 ON t.station_id_end = s2.id'
            .' WHERE u.id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uid]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getUnavailableSeats($tripID) : array {
        $conn = Connection::get();

        $sql = "SELECT seat FROM tickets ti"
            ." JOIN trips t ON ti.trip_id=t.id"
            ." WHERE t.id = ? AND status = 'active'";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$tripID]);

        return $stmt->fetchAll();
    }
}