<?php

class MessagesService {
    public static function add(array $data) : bool {
        return Database::add('messages', $data);
    }

    public static function get(string $col, string $comparison, mixed $value) : array {
        return Database::get('messages', $col, $comparison, $value);
    }

    public static function getAll() : array {
        return Database::getAll('messages');
    }

    public static function update(string $col, string $value, int $id) : bool {
        return Database::update('messages', $col, $value, $id);
    }

    public static function delete(int $id) : bool {
        return Database::delete('messages', $id);
    }

}