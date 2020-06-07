<?php

namespace App\Db;

use PDO;

class QueryBuilder
{
    protected $pdo;

    public function __construct()
    {
        $dbOptions = (require __DIR__ . '/../config.php')['database'];
        $this->pdo = new PDO(
            "{$dbOptions['connection']};dbname={$dbOptions['databasename']};charset={$dbOptions['charset']};",
            $dbOptions['username'],
            $dbOptions['password']
        );
    }

    public function getAll($table)
    {
        $sql = "SELECT * FROM {$table}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllJoin($table, $joinTalble, $reletedRow)
    {
        $sql = "SELECT * FROM {$table} JOIN {$joinTalble} ON {$table}.{$reletedRow}={$joinTalble}.{$reletedRow}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllJoinWhere($table, $joinTalbl, $reletedRow, $row, $value)
    {
        $sql = "SELECT * FROM {$table} JOIN {$joinTalbl} ON {$table}.{$reletedRow}={$joinTalbl}.{$reletedRow} WHERE {$row}={$value}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($table, $data)
    {
        $keys = implode(',', array_keys($data));
        $tegs = ":" . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$tegs})";
        $statement = $this->pdo->prepare($sql);
        return $statement->execute($data);
    }

    public function getOne($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllByRow($table, $row, $value)
    {
        $sql = "SELECT * FROM {$table} WHERE {$row}=:value";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':value', $value);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getOneByRow($table, $data, $row, $value)
    {
        $sql = "SELECT {$data} FROM {$table} WHERE {$row}=:value";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':value', $value);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $idName, $id)
    {
        $keys = array_keys($data);
        $string = '';
        foreach ($keys as $key) {
            $string .= $key . '=:' . $key . ',';
        }
        $keys = rtrim($string, ',');
        $data['id'] = $id;
        $sql = "UPDATE {$table} SET {$keys} WHERE {$idName}=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    public function delete($table, $idName, $id)
    {
        $sql = "DELETE FROM {$table} WHERE {$idName}=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
