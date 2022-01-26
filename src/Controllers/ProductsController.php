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

    public function getProduct(int $id): array
    {
        return $this->productRepository->getProduct($id);
    }

    public function getProducts(int $page, string $orderBy, string $orderType): array
    {
        return $this->productRepository->getAll($page, $orderBy, $orderType);
    }

    public function search(array $filters, int $page, string $orderBy, string $orderType): array
    {
        return $this->productRepository->searchProducts($filters, $page, $orderBy, $orderType);
    }
}
