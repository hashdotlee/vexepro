<?php
class Request {
    public static function getMethod() : string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public static function isPost() : bool {
        return self::getMethod() == 'post';
    }

    public static function isGet() : bool {
        return self::getMethod() == 'get';
    }

    public static function getFields() : array {
        $data = [];
        if (self::isGet()) {
            $data = self::getFields2($_GET);
        }
        if (self::isPost()) {
            $data = self::getFields2($_POST);
        }
        return $data;
    }

    private static function getFields2(array $method) : array {
        $dataFields = [];

        if (!empty($method)) {
            foreach ($method as $key=>$value) {
                $dataFields[$key] = $value;
            }
        }
        return $dataFields;
    }
}