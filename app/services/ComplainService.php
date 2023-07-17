<?php

class ComplainService {
    public static function add(array $data) : bool {
        return Database::add('complains', $data);
    }

    public static function get(string $col, string $comparison, mixed $value) : array {
        return Database::get('complains', $col, $comparison, $value);
    }

    public static function getAll() : array {
        return Database::getAll('complains');
    }

    public static function update(string $col, string $value, int $id) : bool {
        return Database::update('complains', $col, $value, $id);
    }

    public static function delete(int $id) : bool {
        return Database::delete('complains', $id);
    }

}