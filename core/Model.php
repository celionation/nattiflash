<?php

namespace core;

use core\database\Database;
use Exception;
use PDO;

class Model
{
    protected static $table = "";
    protected static $columns = false;
    protected $_validationPassed = true, $_errors = [], $_skipUpdate = [];


    /**
     * @param bool $setFetchClass
     * @return Database
     */
    protected static function getDb(bool $setFetchClass = false): Database
    {
        $db = Database::getInstance();
        if ($setFetchClass) {
            $db->setClass(get_called_class());
            $db->setFetchType(PDO::FETCH_CLASS);
        }
        return $db;
    }


    /**
     * @param $values
     * @return bool
     */
    public static function insert($values)
    {
        $db = static::getDb();
        return $db->insert(static::$table, $values);
    }


    /**
     * @param $values
     * @param $conditions
     * @return bool
     */
    public static function update($values, $conditions)
    {
        $db = static::getDb();
        return $db->update(static::$table, $values, $conditions);
    }


    /**
     * @return Database
     */
    public function delete()
    {
        $db = static::getDb();
        $table = static::$table;
        $params = [
            'conditions' => "id = :id",
            'bind' => ['id' => $this->id]
        ];
        list('sql' => $conds, 'bind' => $bind) = self::queryParamBuilder($params);
        $sql = "DELETE FROM {$table} {$conds}";
        return $db->execute($sql, $bind);
    }

    public static function find($params = [])
    {
        $db = static::getDb(true);
        list('sql' => $sql, 'bind' => $bind) = self::selectBuilder($params);
        return $db->query($sql, $bind)->results();
    }

    public static function findFirst($params = [])
    {
        $db = static::getDb(true);
        list('sql' => $sql, 'bind' => $bind) = self::selectBuilder($params);
        $results = $db->query($sql, $bind)->results();
        return $results[0] ?? false;
    }


    /**
     * findById get data from the database by the id
     * @param $id
     * @return false|mixed
     * @version 1.0.0
     * @author Celio Natti
     */
    public static function findById($id)
    {
        return static::findFirst([
            'conditions' => "id = :id",
            'bind' => ['id' => $id]
        ]);
    }


    /**
     * findTotal functionality that get the total numbers of data in a query
     * @param array $params for all values to get the query
     * @return int return found in the database
     * @version 1.0.0
     * @author Celio Natti
     */
    public static function findTotal(array $params = []): int
    {
        unset($params['limit']);
        unset($params['offset']);
        $table = static::$table;
        $sql = "SELECT COUNT(*) AS total FROM {$table}";
        list('sql' => $conds, 'bind' => $bind) = self::queryParamBuilder($params);
        $sql .= $conds;
        $db = static::getDb();
        $results = $db->query($sql, $bind);
        return sizeof($results->results()) > 0 ? $results->results()[0]->total : 0;
    }

    /**
     * Search functionality that searched records in a table
     * @param string $scope defines the columns to search in the database separated by commas
     * @param string $keywords defines the wildcard pattern to look for
     * @return array $result results found in the database
     * @throws Exception
     * @version 1.0
     * @author Celio Natti
     */
    public function search(string $scope, string $keywords): array
    {
        $db = static::getDb();
        // clean up the input
        $scopeArray = explode(',', $scope);
        $keywords = trim($keywords);
        $sql = '';

        //build the query
        foreach ($scopeArray as $key => $value) {
            $DS = ' OR ';
            if ($key == count($scopeArray) - 1) {
                $DS = '';
            }
            $value = sanitize(trim($value));
            $sql .= "`$value`" . ' LIKE ' . "'$keywords'" . $DS;
        }

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $sql;

        // Execute the result
        $result = $db->execute($sql);
        $renderedResult = array();
        foreach ($result as $key => $value) {
            $renderedResult[] = $this->arrayToModel($value);
        }
        return $renderedResult;
    }


    /**
     * @return bool
     */
    public function save(): bool
    {
        $save = false;
        $this->beforeSave();
        if ($this->_validationPassed) {
            $db = static::getDb();
            $values = $this->getValuesForSave();
            if ($this->isNew()) {
                $save = $db->insert(static::$table, $values);
                if ($save) {
                    $this->id = $db->lastInsertId();
                }
            } else {
                $save = $db->update(static::$table, $values, ['id' => $this->id]);
            }
        }
        return $save;
    }

    public function isNew(): bool
    {
        return empty($this->id);
    }


    /**
     * @param array $params
     * @return array
     */
    public static function selectBuilder(array $params = []): array
    {
        $columns = array_key_exists('columns', $params) ? $params['columns'] : "*";
        $table = static::$table;
        $sql = "SELECT {$columns} FROM {$table}";
        list('sql' => $conds, 'bind' => $bind) = self::queryParamBuilder($params);
        $sql .= $conds;
        return ['sql' => $sql, 'bind' => $bind];
    }


    /**
     * @param array $params
     * @return array
     */
    public static function queryParamBuilder(array $params = []): array
    {
        $sql = "";
        $bind = array_key_exists('bind', $params) ? $params['bind'] : [];
        // joins
        // [['table2', 'table1.id = table2.key', 'tableAlias', 'LEFT' ]]
        if (array_key_exists('joins', $params)) {
            $joins = $params['joins'];
            foreach ($joins as $join) {
                $joinTable = $join[0];
                $joinOn = $join[1];
                $joinAlias = $join[2] ?? "";
                $joinType = isset($join[3]) ? "{$join[3]} JOIN" : "JOIN";
                $sql .= " {$joinType} {$joinTable} {$joinAlias} ON {$joinOn}";
            }
        }

        // where
        if (array_key_exists('conditions', $params)) {
            $conds = $params['conditions'];
            $sql .= " WHERE {$conds}";
        }

        // group
        if (array_key_exists('group', $params)) {
            $group = $params['group'];
            $sql .= " GROUP BY {$group}";
        }

        // order
        if (array_key_exists('order', $params)) {
            $order = $params['order'];
            $sql .= " ORDER BY {$order}";
        }

        // limit
        if (array_key_exists('limit', $params)) {
            $limit = $params['limit'];
            $sql .= " LIMIT {$limit}";
        }

        // offset
        if (array_key_exists('offset', $params)) {
            $offset = $params['offset'];
            $sql .= " OFFSET {$offset}";
        }
        return ['sql' => $sql, 'bind' => $bind];
    }

    public function getValuesForSave(): array
    {
        $columns = static::getColumns();
        $values = [];
        foreach ($columns as $column) {
            if (!in_array($column, $this->_skipUpdate)) {
                $values[$column] = $this->{$column};
            }
        }
        return $values;
    }


    /**
     * @return bool
     */
    public static function getColumns(): bool
    {
        if (!static::$columns) {
            $db = static::getDb();
            $table = static::$table;
            $sql = "SHOW COLUMNS FROM {$table}";
            $results = $db->query($sql)->results();
            $columns = [];
            foreach ($results as $column) {
                $columns[] = $column->Field;
            }
            static::$columns = $columns;
        }
        return static::$columns;
    }

    public function runValidation($validator)
    {
        $validates = $validator->runValidation();
        if (!$validates) {
            $this->_validationPassed = false;
            $this->_errors[$validator->field] = $validator->msg;
        }
    }

    public function getErrors(): array
    {
        return $this->_errors;
    }

    public function setError($name, $value)
    {
        $this->_errors[$name] = $value;
        $this->_validationPassed = false;
    }

    /**
     * @throws Exception
     */
    public function timeStamps(): void
    {
        $dt = new \DateTime("now", new \DateTimeZone("UTC"));
        $now = $dt->format('Y-m-d H:i:s');
        $this->updated_at = $now;
        if ($this->isNew()) {
            $this->created_at = $now;
        }
    }

    public static function mergeWithPagination($params = [])
    {
        $request = new Request();
        $page = $request->get('p');
        if (!$page || $page < 1) $page = 1;
        $limit = $request->get('limit') ? $request->get('limit') : 25;
        $offset = ($page - 1) * $limit;
        $params['limit'] = $limit;
        $params['offset'] = $offset;
        return $params;
    }


    public function beforeSave()
    {
    }

}