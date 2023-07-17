<?php
class UserService {
    public static function add(array $data) : bool {
        return Database::add('users', $data);
    }

    public static function get(string $col, string $comparison, mixed $value) : array {
        return Database::get('users', $col, $comparison, $value);
    }

    public static function getAll() : array {
        return Database::getAll('users');
    }

    public static function update(string $col, string $value, int $id) : bool {
        return Database::update('users', $col, $value, $id);
    }

    public static function delete(int $id) : bool {
        return Database::delete('users', $id);
    }

    public static function deactivate(int $id) : bool {
        return Database::update('users', 'deactivate_flag', '1', $id);
    }

    public static function activate(int $id) : bool {
        return Database::update('users', 'deactivate_flag', '0', $id);
    }
}