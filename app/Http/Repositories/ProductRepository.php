<?php
namespace App\Http\Repositories;

use App\Product;
use Illuminate\Support\Facades\Input;

/**
 * Class ProductRepository
 */
class ProductRepository extends Repository
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $qb = Product::whereNotNull('products.created_at')
            ->with('orders');
        $qb = $this->order($qb);
        $qb = $this->applyFilters($qb);
        $qb = $this->search($qb);
        $products = $qb->get();
        return $products;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $product = Product::findOrFail($id);
        return $product;
    }

    /**
     * @param array $data
     * @return \App\Product
     * @throws \Exception
     */
    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $product = new \App\Product();
            $product->fill($data);
            $product->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $product;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function update($id, $data)
    {

        \DB::beginTransaction();
        try {
            $product = $this->findOne($id);
            $product->fill($data);
            $product->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $product;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        \DB::beginTransaction();
        try {
            $product = $this->findOne($id);
            $product->delete();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

    /**
     * @param $queryBuilder
     * @return mixed
     */
    public function search($queryBuilder)
    {
        $value = Input::get('search');
        $queryBuilder->where('name', 'like', '%'.$value.'%');
        return $queryBuilder;
    }


    /**
     * @param $queryBuilder
     * @return mixed
     */
    public function order($queryBuilder)
    {
        $orderBy = Input::get('order_by');
        if ($orderBy) {
            $orderDirection = Input::get('direction');

            switch ($orderBy) {

                case 'last_ordered':
                    $queryBuilder
                        ->select(['products.*'])
                        ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
                        ->orderBy('order_product.created_at', $orderDirection);
                    break;

                case 'units_sold':
                    $queryBuilder
                        ->select(['products.*', \DB::raw('count(order_product.product_id) as total')])
                        ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
                        ->groupBy('products.id')
                        ->orderBy('total', $orderDirection);
                    break;

                default:
                    $queryBuilder->orderBy($orderBy, $orderDirection);
                    break;
            }

        }

        return $queryBuilder;
    }

}
