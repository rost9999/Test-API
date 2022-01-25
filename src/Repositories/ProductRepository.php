<?php

namespace Repositories;

use Components\DbConnection;
use PDO;

class ProductRepository
{
    private PDO $pdo;
    private int $count = 5;

    public function __construct()
    {
        $this->pdo = DbConnection::getInstance();
    }

    public function getAll($page, $orderBy, $orderType): array
    {
        $offset = $page * $this->count;
        $stmt = $this->pdo->prepare("SELECT * FROM products ORDER BY $orderBy $orderType LIMIT $this->count OFFSET $offset");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduct(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchProducts($filters, $page, $orderBy, $orderType): array
    {
        $offset = $page * $this->count;
        $filtersString = [];
        foreach ($filters as $key => $item) {
            $filtersString[] = "$key = :$key";
        }
        $filtersString = implode(' and ', $filtersString);
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE $filtersString ORDER BY $orderBy $orderType LIMIT $this->count OFFSET $offset");
        $stmt->execute($filters);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}