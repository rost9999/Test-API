<?php

namespace Repositories;

use Components\DbConnection;
use PDO;

class ProductRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DbConnection::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduct(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchProducts($filters)
    {
        $stringFilter = '';
        foreach ($filters as $key => $item) {
            $filters .= $key .' = :'.$item;
        }
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE $colum LIKE :keyword");
        $stmt = $this->pdo->
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}