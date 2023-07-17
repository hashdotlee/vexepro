<?php
class Connection {
    private static ?PDO $conn = null;

    private function __construct(){}

    public static function connect() : object {
        global $config;
        $db_config = array_filter($config['database']);
        //Kết nối database
        //Cấu hình dsn
        $dsn = 'mysql:dbname='.$db_config['db'].';host='.$db_config['host'];

        //Cấu hình $options
        /*
         * - Cấu hình utf8
         * - Cấu hình ngoại lệ khi truy vấn bị lỗi
         * */
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        //Câu lệnh kết nối
        self::$conn = new PDO($dsn, $db_config['user'], $db_config['password'], $options);
        return self::$conn;
    }

    public static function get() : object {
        if (self::$conn == null) {
            self::$conn = @self::connect();
        }
        return self::$conn;
    }
}