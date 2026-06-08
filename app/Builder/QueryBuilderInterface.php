<?php

namespace App\Builder;

interface QueryBuilderInterface {
    public function select(array $fields): self;
    public function where(string $column, string $value): self;
    public function limit(int $value): self;
    public function getQuery(): SQLQuery; // နောက်ဆုံး ထွက်ကုန်ကို ယူမည့် Method
}
