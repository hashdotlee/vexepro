<?php
class AgencyService {
    public static function add(array $data) : bool {
        echo 'Adding';
        return Database::add('agencies', $data);
    }

    public static function get(string $col, string $comparison, mixed $value) : array {
        return Database::get('agencies', $col, $comparison, $value);
    }

    public static function getAll() : array {
        return Database::getAll('agencies');
    }

    public static function update(string $col, string $value, int $id) : bool {
        return Database::update('agencies', $col, $value, $id);
    }

    public static function delete(int $id) : bool {
        return Database::delete('agencies', $id);
    }
}