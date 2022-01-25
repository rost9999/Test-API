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


    public function products($id = null): array
    {
        if ($id == null) {
            $products = $this->productRepository->getAll();
        } else {
            $products = $this->productRepository->getProduct($id);
        }
        return $products;
    }

    public function search($filters)
    {

        $products = $this->search($colum,$keyword);
        return $products;
    }

}