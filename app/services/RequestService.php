<?php

class RequestService {
    public static function add(array $data) : bool {
        return Database::add('requests', $data);
    }

    public static function get(string $col, string $comparison, mixed $value) : array {
        return Database::get('requests', $col, $comparison, $value);
    }

    public static function getAll() : array {
        return Database::getAll('requests');
    }

    public static function update(string $col, string $value, int $id) : bool {
        return Database::update('requests', $col, $value, $id);
    }

    public static function delete(int $id) : bool {
        return Database::delete('requests', $id);
    }

}