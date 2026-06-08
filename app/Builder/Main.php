<?php

namespace App\Builder;

class Main {
    public function run() {
        $queryBuilder = new MysqlQueryBuilder('users');
        $query = $queryBuilder
            ->select(['id', 'name'])
            ->where('status', 'active')
            ->limit(10)
            ->getQuery();

        echo $query->getSQL();
    }
}
