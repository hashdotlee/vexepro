<?php
require_once _DIR_ROOT . '/app/dao/TripDao.php';

class TripService
{

    public static function add(array $data): bool
    {
        return Database::add('trips', $data);
    }

    public static function get(string $col, string $comparison, mixed $value): array
    {
        return Database::get('trips', $col, $comparison, $value);
    }

    public static function getAll(): array
    {
        return Database::getAll('trips');
    }

    public static function update(string $col, string $value, int $id): bool
    {
        return Database::update('trips', $col, $value, $id);
    }

    public static function updateMany($data, $where): bool
    {
        return Database::updateMany('trips', $data, $where);
    }

    public static function delete(int $id): bool
    {
        return Database::delete('trips', $id);
    }

    public static function seed(int $n): void
    {
    }

    public static function search(array $filter): array
    {
        return TripDao::search($filter);
    }

    public static function decreaseRemainingSlots(int $id, int $amount): bool
    {
        $trip = Database::get('trips', 'id', '=', $id);

        if ($trip == null) return false;
        else $trip = $trip[0];

        if ($trip->remaining_slots >= $amount)
            Database::update('trips', 'remaining_slots', $trip->remaining_slots - $amount, $id);
        else
            return false;

        return true;
    }

    public static function increaseRemainingSlots(int $id, int $amount): bool
    {
        $trip = Database::get('trips', 'id', '=', $id);

        if ($trip == null) return false;
        else $trip = $trip[0];
        $capacity = VehicleService::getCapacity($trip->vehicle_id);
        if ($trip->remaining_slots + $amount <= $capacity)
            Database::update('trips', 'remaining_slots', $trip->remaining_slots + $amount, $id);
        else
            return false;

        return true;
    }

    public static function getUnavailableSeats(int $tripID): array
    {
        $objArr = TripDao::getUnavailableSeats($tripID);

        $seats = [];
        foreach ($objArr as $seat) {
            $seats[] = $seat->seat;
        }
        return $seats;
    }

    public static function getAllWithDetails(): array
    {
        return TripDao::getAllWithDetail();
    }
    public static function getPopularWithDetails(): array
    {
        return TripDao::getAllPopularWithDetail();
    }
    public static function getAllWithDetailsById(int $tripID): array
    {
        return TripDao::getAllWithDetailById($tripID);
    }
}
