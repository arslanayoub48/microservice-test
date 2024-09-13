<?php
namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Exception;

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
        DB::beginTransaction();
        try {
            $product = $this->productRepository->create($data);
            DB::commit();
            return $this->successResponse($product, 'Product created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create product', $e->getMessage(), 500);
        }
    }

    public function updateProduct($id, $data)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->update($id, $data);
            DB::commit();
            return $this->successResponse($product, 'Product updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to update product', $e->getMessage(), 500);
        }    }

    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try {
            $this->productRepository->delete($id);
            DB::commit();
            return $this->successResponse(null, 'Product deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to delete product', $e->getMessage(), 500);
        }
    }
}
