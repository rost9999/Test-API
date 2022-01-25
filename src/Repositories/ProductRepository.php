<?php

namespace Repositories;

use Components\DbConnection;
use PDO;

class ProductRepository
{
    private PDO $pdo;
    const PER_PAGE = 5;

    public function __construct()
    {
        $this->pdo = DbConnection::getInstance();
    }

    public function getAll($page, $orderBy, $orderType): array
    {
        $offset = ($page - 1) * self::PER_PAGE;
        $stmt = $this->pdo->prepare('SELECT * FROM products ORDER BY :orderby :ordertype LIMIT 5 OFFSET 0');
        $stmt->execute([
            'orderby' => $orderBy,
            'ordertype' => $orderType,
//            'offset' => $offset,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduct(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchProducts(array $filters, int $page, string $orderBy, string $orderType): array
    {
        $offset = ($page - 1) * self::PER_PAGE;
        $filtersString = [];
        foreach ($filters as $key => $item) {
            $filtersString[] = "$key = :$key";
        }
        $filtersString = implode(' and ', $filtersString);
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE $filtersString ORDER BY $orderBy $orderType LIMIT 5 OFFSET $offset");
        $stmt->execute($filters);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}