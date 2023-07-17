<?php
class StationService {
    public static function add(array $data) : bool {
        return Database::add('stations', $data);
    }

    public static function get(string $col, string $comparison, mixed $value) : array {
        return Database::get('stations', $col, $comparison, $value);
    }

    public static function getAll() : array {
        return Database::getAll('stations');
    }

    public static function update(string $col, string $value, int $id) : bool {
        return Database::update('stations', $col, $value, $id);
    }

    public static function delete(int $id) : bool {
        return Database::delete('stations', $id);
    }

    public static function getProvinces() : array {
        $objArr = Database::getDistinct('stations', 'province');

        $provinces = [];
        foreach ($objArr as $province) {
            $provinces[] = $province->province;
        }
        return $provinces;
    }
}