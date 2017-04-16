<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use App\Http\Transformers\ProductTransformer;
use App\Product;
use Illuminate\Events\Dispatcher;

/**
 * Class ProductService
 * @package App\Http\Services
 */
class ProductService extends Service
{

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductTransformer
     */
    private $productTransformer;

    /**
     * ProductService constructor.
     * @param Dispatcher $dispatcher
     * @param ProductRepository $productRepository
     * @param ProductTransformer $productTransformer
     */
    public function __construct(
        Dispatcher $dispatcher,
        ProductRepository $productRepository,
        ProductTransformer $productTransformer
    ) {
        $this->dispatcher = $dispatcher;
        $this->productRepository = $productRepository;
        $this->productTransformer = $productTransformer;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $product = $this->productRepository->findOne($id);
        $product = $this->productTransformer->transformItem($product);
        return $product;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $products = $this->productRepository->findAll();
        $products = $this->productTransformer->transformCollection($products);

        $pagination = $this->pagination(Product::class);

        return ['items' => $products, 'pagination' => $pagination];
    }



    /**
     * @param array $data
     * @return \App\Product
     * @throws \Exception
     */
    public function create(array $data)
    {
        $product = $this->productRepository->create($data);
        $product = $this->productTransformer->transformItem($product);

        return $product;
    }


    /**
     * @param $id
     * @param array $data
     * @return array|mixed
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        $product = $this->productRepository->update($id, $data);
        $product = $this->productTransformer->transformItem($product);
        return $product;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->productRepository->delete($id);
    }


}