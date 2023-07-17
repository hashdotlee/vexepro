<?php
class VehicleTypeService {
    public static function add(array $data) : bool {
        return Database::add('vehicle_types', $data);
    }

    public static function get(string $col, string $comparison, mixed $value) : array {
        return Database::get('vehicle_types', $col, $comparison, $value);
    }

    public static function getAll() : array {
        return Database::getAll('vehicle_types');
    }

    public static function update(string $col, string $value, int $id) : bool {
        return Database::update('vehicle_types', $col, $value, $id);
    }

    public static function delete(int $id) : bool {
        return Database::delete('vehicle_types', $id);
    }
}