<?php

namespace App\Builder;

class MysqlQueryBuilder implements QueryBuilderInterface {
    private SQLQuery $query;

    public function __construct(string $table) {
        $this->query = new SQLQuery();
        $this->query->table = $table;
    }

    public function select(array $fields): self {
        $this->query->fields = $fields;
        return $this;
    }

    public function where(string $column, string $value): self {
        $this->query->wheres[] = "$column = '$value'";
        return $this;
    }

    public function limit(int $value): self {
        $this->query->limit = (string) $value;
        return $this;
    }

    public function getQuery(): SQLQuery {
        return $this->query;
    }
}
