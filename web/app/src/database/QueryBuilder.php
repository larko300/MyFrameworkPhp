<?php

namespace App\Db;

use PDO;

class QueryBuilder
{
    protected $pdo;

    private static $instance;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../config.php')['database'];
        $this->pdo = new PDO(
            "{$dbOptions['connection']};dbname={$dbOptions['databasename']};charset={$dbOptions['charset']};",
            $dbOptions['username'],
            $dbOptions['password']
        );
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getAll($table, string $className = 'stdClass')
    {
        $sql = "SELECT * FROM {$table}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public function create($table, $data)
    {
        $filteredData = array_filter($data);
        $keys = implode(',', array_keys($filteredData));
        $tegs = ":" . implode(', :', array_keys($filteredData));
        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tegs})";
        $statement = $this->pdo->prepare($sql);
        return $statement->execute($filteredData);
    }

    public function getOneByRow($table, $column, $value, string $className = 'stdClass')
    {
        $sql = "SELECT * FROM {$table} WHERE {$column}=:value";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':value', $value);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public function getOne($table, $id, string $className = 'stdClass')
    {
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public function update($table, $data, $id)
    {
        $keys = array_keys($data);
        $string = '';
        foreach ($keys as $key) {
            $string .= $key . '=:' . $key . ',';
        }
        $keys = rtrim($string, ',');
        $data['id'] = $id;
        $sql = "UPDATE {$table} SET {$keys} WHERE id =:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id =:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
