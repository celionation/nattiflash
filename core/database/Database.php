<?php

namespace core\database;

use core\Config;
use Exception;
use PDO;

class Database
{
    protected $_dbh, $_results, $_class;
    protected int $_fetchType = PDO::FETCH_OBJ;
    protected mixed $_lastInsertId;
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


    /**
     * @param $sql
     * @param array $bind
     * @return $this
     */
    public function execute($sql, array $bind = [])
    {
        $this->_results = null;
        $this->_lastInsertId = null;
        $this->_error = false;
        $this->_stmt = $this->_dbh->prepare($sql);
        if (!$this->_stmt->execute($bind)) {
            $this->_error = true;
        } else {
            $this->_lastInsertId = $this->_dbh->lastInsertId();
        }
        return $this;
    }


    /**
     * @param $sql
     * @param array $bind
     * @return $this
     */
    public function query($sql, array $bind = [])
    {
        $this->execute($sql, $bind);
        if (!$this->_error) {
            $this->_rowCount = $this->_stmt->rowCount();
            if ($this->_fetchType === PDO::FETCH_CLASS) {
                $this->_results = $this->_stmt->fetchAll($this->_fetchType, $this->_class);
            } else {
                $this->_results = $this->_stmt->fetchAll($this->_fetchType);
            }
        }
        return $this;
    }


    /**
     * @return mixed
     */
    public function results()
    {
        return $this->_results;
    }


    /**
     * @return int
     */
    public function count(): int
    {
        return $this->_rowCount;
    }


    /**
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->_lastInsertId;
    }

    public function setClass($class)
    {
        $this->_class = $class;
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function setFetchType($type)
    {
        $this->_fetchType = $type;
    }

    public function getFetchType()
    {
        return $this->_fetchType;
    }

}