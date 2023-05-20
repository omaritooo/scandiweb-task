<?php

namespace Infrastructure\Model;

use Infrastructure\App\App;
use Infrastructure\Database\DB;
use PDO;

abstract class Model
{
    protected DB $db;

    protected string $tableName;

    public function __construct()
    {
        $this->db = App::db();
    }

    public static function query()
    {
        return new static();
    }

    public function all(array $columns = ['*']): array
    {
        $columns = implode(',', $columns);

        return $this->db
            ->query("SELECT {$columns} FROM $this->tableName")
            ->fetchAll();
    }

    public function create(array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $values = array_values($data);
        $placeholders = $this->getPlaceholders(count($values));

        return $this->db
            ->prepare("INSERT INTO {$this->tableName} ( {$columns} ) VALUES ( {$placeholders} )")
            ->execute($values);
    }

    public function delete(array $id, string $column = 'id'): bool
    {
        $placeholders = $this->getPlaceholders(count($id));

        return $this->db
            ->prepare("DELETE FROM {$this->tableName} WHERE {$column} IN ( {$placeholders} )")
            ->execute($id);
    }

    public function exists($value, string $tableName, string $column): bool
    {
        $stmt = $this->db->prepare("select count(*) as count from `{$tableName}` where `{$column}` = :value");
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$data['count'] === 0;
    }

    private function getPlaceholders(int $count): string
    {
        $result = [];

        foreach (range(1, $count) as $num) {
            $result[] = "?";
        }

        return implode(',', $result);
    }
}