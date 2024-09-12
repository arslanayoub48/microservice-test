<?php
namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Traits\ApiResponse;

class ProductService
{
    use ApiResponse;
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return $this->successResponse($this->productRepository->all());
    }

    public function createProduct($data)
    {
        return $this->successResponse($this->productRepository->create($data), 'Product created successfully');
    }

    public function updateProduct($id, $data)
    {
        return $this->successResponse($this->productRepository->update($id, $data), 'Product updated successfully');
    }

    public function deleteProduct($id)
    {
        $this->productRepository->delete($id);
        return $this->successResponse(null, 'Product deleted successfully');
    }
}
