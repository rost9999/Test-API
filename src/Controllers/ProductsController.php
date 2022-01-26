<?php

namespace Controllers;

use repositories\ProductRepository;

class ProductsController
{
    protected ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function getProduct(int $productID): array
    {
        return $this->productRepository->getProduct($productID);
    }

    public function getProducts(int $pageID, string $orderBy, string $orderType): array
    {
        return $this->productRepository->getAll($pageID, $orderBy, $orderType);
    }

    public function search(array $filters, int $page, string $orderBy, string $orderType): array
    {
        return $this->productRepository->searchProducts($filters, $page, $orderBy, $orderType);
    }
}
