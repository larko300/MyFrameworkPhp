<?php

namespace App\Model;

use App\Db\QueryBuilder;

abstract class ActiveRecordEntity
{

    protected $id;

    public function getId(): int
    {
        return $this->id;
    }
    public static function findAll()
    {
        $db = QueryBuilder::getInstance();
        return $db->getAll(static::getTableName(), static::class);
    }

    public static function getById(int $id)
    {
        $db = QueryBuilder::getInstance();
        $entities = $db->getOne(static::getTableName(), $id, static::class);
        return $entities ? $entities[0] : null;
    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    private function update(array $mappedProperties): void
    {
        $db = QueryBuilder::getInstance();
        $db->update(static::getTableName(), $mappedProperties, $this->id);
    }

    private function insert(array $mappedProperties): void
    {
        $db = QueryBuilder::getInstance();
        $db->create(static::getTableName(), $mappedProperties);
        $this->id = $db->getLastInsertId();
    }

    public function delete(): void
    {
        $db = QueryBuilder::getInstance();
        $db->delete(static::getTableName(), $this->id);
        $this->id = null;
    }

    public static function findOneByColumn(string $columnName, $value)
    {
        $db = QueryBuilder::getInstance();
        $result = $db->getOneByRow(static::getTableName(), $columnName, $value, static::class);
        if ($result === []) {
            return null;
        }
        return $result[0];
    }

    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }


    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }



    abstract protected static function getTableName(): string;
}
