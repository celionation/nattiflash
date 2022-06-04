<?php

namespace core\database;

use core\Config;
use Exception;
use PDO;

class Database
{
    protected $_dbh, $_results, $_lastInsertId, $_class;
    protected int $_fetchType = PDO::FETCH_OBJ;
    protected bool $_error = false;
    protected int $_rowCount = 0;
    protected $_stmt;
    protected static $_db;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $host = Config::get('db_host');
        $name = Config::get('db_name');
        $user = Config::get('db_user');
        $pass = Config::get('db_password');
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];
        try {
            $this->_dbh = new PDO("mysql:host={$host};dbname={$name}", $user, $pass, $options);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (!self::$_db) {
            self::$_db = new self();
        }
        return self::$_db;
    }

}