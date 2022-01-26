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
        $stmt = $this->pdo->prepare('SELECT * FROM products ORDER BY :orderby :ordertype LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':orderby', $orderBy);
        $stmt->bindValue(':ordertype', $orderType);
        $stmt->bindValue(':limit', (int)self::PER_PAGE, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
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
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE $filtersString ORDER BY $orderBy $orderType LIMIT " . self::PER_PAGE . " OFFSET $offset");
        $stmt->execute($filters);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}