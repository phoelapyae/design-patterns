<?php

namespace App\Builder;

class SQLQuery {
    public string $table;
    public array $fields = ['*'];
    public array $wheres = [];
    public string $limit = '';

    public function getSQL(): string {
        $sql = "SELECT " . implode(', ', $this->fields) . " FROM " . $this->table;
        if (!empty($this->wheres)) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }
        if ($this->limit) {
            $sql .= " LIMIT " . $this->limit;
        }
        return $sql;
    }
}
