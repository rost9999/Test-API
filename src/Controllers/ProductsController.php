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


    public function getProduct($id): array
    {
        $products = $this->productRepository->getProduct($id);
        return $products;
    }

    public function getProducts($page, $orderBy, $orderType): array
    {
        $products = $this->productRepository->getAll($page, $orderBy, $orderType);
        return $products;
    }

    public function search($filters, $page, $orderBy, $orderType): array
    {
        $products = $this->productRepository->searchProducts($filters, $page, $orderBy, $orderType);
        return $products;
    }

}