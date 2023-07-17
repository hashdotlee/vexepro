<?php
require_once _DIR_ROOT.'/app/dao/TicketDao.php';

class TicketService {
    public static function add(array $data) : bool {
        return Database::add('tickets', $data);
    }

    public static function get(string $col, string $comparison, mixed $value) : array {
        return Database::get('tickets', $col, $comparison, $value);
    }

    public static function getAll() : array {
        return Database::getAll('tickets');
    }

    public static function update(string $col, string $value, int $id) : bool {
        return Database::update('tickets', $col, $value, $id);
    }

    public static function cancel(int $id) : bool {
        return Database::delete('tickets',  $id);
    }


    public static function getByUserId(int $uid) : array {
        return TicketDao::getByUserID($uid);
    }
}