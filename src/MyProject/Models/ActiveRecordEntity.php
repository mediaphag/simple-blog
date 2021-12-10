<?php

namespace MyProject\Models;

use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * @return static[]
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    abstract protected static function getTableName(): string;

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
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
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    private function insert(array $mappedProperties): void
    {
        $mappedPropertiesNotNull = array_filter($mappedProperties, function ($value) {
            return $value !== null;
        });

        $columns2fields = [];
        $params2values = [];
        $params = [];
        $index = 1;
        foreach ($mappedPropertiesNotNull as $column => $value) {
            $columns2fields[] = $column; // fields
            $param = ':param' . $index; // :param1
            $params[] = $param; // :param[]
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
        }

        $sql = 'INSERT INTO ' . static::getTableName() . ' ('
            . implode(', ', $columns2fields)
            . ') VALUES ('
            . implode(', ', $params)
            . ')';

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);

        $this->id = $db->getLastInsertId();
        $this->refresh();

//        $createdEntity = $this->getById($this->id);
//        $reflectorCreatedEntity = new \ReflectionObject($createdEntity);
//        $propertiesCreatedEntity = $reflectorCreatedEntity->getProperties();
//        var_dump($propertiesCreatedEntity);
//
//        foreach ($propertiesCreatedEntity as $propertyCreatedEntity) {
//            $tempProperty = $propertyCreatedEntity->getName();
//            if ($this->$tempProperty == null) {
//                $this->$tempProperty = $createdEntity->$tempProperty;
//            }
//        }

    }

    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query(
            'DELETE FROM `' . static::getTableName() . '` WHERE id = :id',
            [':id' => $this->id]
        );
        $this->id = null;
    }

    public function refresh(): void
    {
        $createdEntity = static::getById($this->id);
        $propertiesCreatedEntity = get_object_vars($createdEntity);

        foreach ($propertiesCreatedEntity as $key => $value) {
            if ($this->$key == null) {
                $this->$key = $value;
            }
        }
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

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }
}