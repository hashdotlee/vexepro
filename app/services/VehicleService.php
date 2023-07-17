<?php
require_once _DIR_ROOT.'/app/dao/VehicleDao.php';

class VehicleService {
    public static function add(array $data) : bool {
        return Database::add('vehicles', $data);
    }

    public static function get(string $col, string $comparison, mixed $value) : array {
        return Database::get('vehicles', $col, $comparison, $value);
    }

    public static function getAll() : array {
        return Database::getAll('vehicles');
    }

    public static function update(string $col, string $value, int $id) : bool {
        return Database::update('vehicles', $col, $value, $id);
    }

    public static function delete(int $id) : bool {
        return Database::delete('vehicles', $id);
    }

    public static function genPlateNumber($n) : array {
        $plate_numbers = [];
        for ($i = 0; $i < $n; $i++) {
            $prefix = rand(29, 33) . chr(rand(65, 70));
            $plate_numbers[$i] = $prefix . '-' . rand(100, 999) . '.' . rand(10, 99);
        }

        return $plate_numbers;
    }

    public static function getAllWithDetails(): array {
        return VehicleDao::getAllWithDetails();
    }
    public static function getAllWithDetailsById(int $id): array {
        return VehicleDao::getAllWithDetailsById($id);
    }

    public static function getCapacity(int $id): int {
        $shape = VehicleDao::getShape($id);
        return $shape->row * $shape->level * $shape->line;
    }
}