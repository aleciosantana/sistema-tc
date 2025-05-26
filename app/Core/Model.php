<?php
namespace App\Core;

use App\Config\Database;
use PDO;
use PDOException;

abstract class Model
{
    public const HAS_MANY = 'hasMany';
    public const BELONGS_TO = 'belongsTo';
    public const HAS_ONE = 'hasOne';
    public const MANY_TO_MANY = 'manyToMany';

    protected static $table;
    protected static $primaryKey = 'id';
    protected $attributes = [];
    protected static $relationships = [];

    protected static function getDb()
    {
        return Database::getInstance();
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public static function all()
    {
        $db = static::getDb();
        $stmt = $db->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function find($id)
    {
        $db = static::getDb();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class);
        return $stmt->fetch();
    }

    public static function create(array $data)
    {
        try {
            $db = static::getDb();
            $columns = array_keys($data);
            $placeholders = array_map(fn($col) => ":$col", $columns);
            $sql = "INSERT INTO " . static::$table . " (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = $db->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            $id = $db->lastInsertId();
            return static::find($id);
        } catch (PDOException $e) {
            error_log("Erro ao criar registro: " . $e->getMessage());
            return null;
        }
    }

    public function save()
    {
        if (isset($this->attributes[static::$primaryKey])) {
            return $this->update();
        }
        $data = $this->attributes;
        return static::create($data);
    }

    protected function update()
    {
        try {
            $columns = array_keys($this->attributes);
            $setClause = array_map(fn($col) => "$col = :$col", array_filter($columns, fn($col) => $col !== static::$primaryKey));
            $sql = "UPDATE " . static::$table . " SET " . implode(', ', $setClause) . " WHERE " . static::$primaryKey . " = :" . static::$primaryKey;
            $stmt = static::getDb()->prepare($sql);

            foreach ($this->attributes as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar registro: " . $e->getMessage());
            return false;
        }
    }

    public function delete()
    {
        if (!isset($this->attributes[static::$primaryKey])) {
            return false;
        }

        try {
            $stmt = static::getDb()->prepare("DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id");
            return $stmt->execute(['id' => $this->attributes[static::$primaryKey]]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir registro: " . $e->getMessage());
            return false;
        }
    }

    public function validate()
    {
        $errors = [];
        if (empty($this->attributes['name'])) {
            $errors[] = 'O campo nome é obrigatório.';
        }
        return $errors;
    }

    protected function defineRelationships()
    {
        return static::$relationships;
    }

    public function getRelationship($relation)
    {
        $relationships = $this->defineRelationships();
        if (!isset($relationships[$relation])) {
            return null;
        }

        $config = $relationships[$relation];
        $relatedModel = $config['model'];
        $foreignKey = $config['foreignKey'];
        $localKey = $config['localKey'] ?? static::$primaryKey;

        if ($config['type'] === self::HAS_MANY) {
            $stmt = static::getDb()->prepare("SELECT * FROM {$relatedModel::$table} WHERE {$foreignKey} = :id");
            $stmt->execute(['id' => $this->attributes[$localKey]]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, $relatedModel);
        } elseif ($config['type'] === self::BELONGS_TO) {
            $stmt = static::getDb()->prepare("SELECT * FROM {$relatedModel::$table} WHERE {$relatedModel::$primaryKey} = :id");
            $stmt->execute(['id' => $this->attributes[$foreignKey]]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $relatedModel);
            return $stmt->fetch();
        } elseif ($config['type'] === self::HAS_ONE) {
            $stmt = static::getDb()->prepare("SELECT * FROM {$relatedModel::$table} WHERE {$foreignKey} = :id");
            $stmt->execute(['id' => $this->attributes[$localKey]]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $relatedModel);
            return $stmt->fetch();
        } elseif ($config['type'] === self::MANY_TO_MANY) {
            $pivotTable = $config['pivotTable'];
            $relatedKey = $config['relatedKey'];
            $sql = "SELECT {$relatedModel::$table}.* FROM {$relatedModel::$table}
                    JOIN {$pivotTable} ON {$relatedModel::$table}.{$relatedModel::$primaryKey} = {$pivotTable}.{$relatedKey}
                    WHERE {$pivotTable}.{$foreignKey} = :id";
            $stmt = static::getDb()->prepare($sql);
            $stmt->execute(['id' => $this->attributes[$localKey]]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, $relatedModel);
        }
        return null;
    }
}