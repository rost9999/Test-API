<?php

namespace Repositories;

use Components\DbConnection;
use PDO;

class ProductRepository
{
    private PDO $pdo;
    const PER_PAGE = 5;

    /**
     *  Connect to DB
     */
    public function __construct()
    {
        $this->pdo = DbConnection::getInstance();
    }

    /**
     * Return all products
     *
     * @param int $pageID
     * @param string $orderBy
     * @param string $orderType
     *
     * @return array
     */
    public function getAll(int $pageID, string $orderBy, string $orderType): array
    {
        $offset = ($pageID - 1) * self::PER_PAGE;

        $stmt = $this->pdo->prepare('SELECT * FROM products ORDER BY :orderby :ordertype LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':orderby', $orderBy);
        $stmt->bindValue(':ordertype', $orderType);
        $stmt->bindValue(':limit', (int)self::PER_PAGE, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Return one product by id
     *
     * @param int $productID
     *
     * @return array
     */
    public function getProduct(int $productID): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $productID]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns products by filter
     *
     * @param array $filters
     * @param int $pageID
     * @param string $orderBy
     * @param string $orderType
     *
     * @return array
     */
    public function searchProducts(array $filters, int $pageID, string $orderBy, string $orderType): array
    {
        $offset = ($pageID - 1) * self::PER_PAGE;

        $filtersString = [];
        foreach ($filters as $key => $item) {
            $filtersString[] = "$key = :$key";
        }
        $filtersString = implode(' and ', $filtersString);

        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE $filtersString ORDER BY $orderBy $orderType LIMIT " . self::PER_PAGE . " OFFSET $offset");
        $stmt->execute($filters);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
