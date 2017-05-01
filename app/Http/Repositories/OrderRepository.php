<?php
namespace App\Http\Repositories;
use App\Order;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

/**
 * Class OrderRepository
 */
class OrderRepository extends Repository
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $qb = Order::with('customer')
            ->with('products')
            ->with('stages')
            ->with(['address' => function($query) {
                $query->withTrashed();
            }]);
        $qb = $this->order($qb);
        $qb = $this->applyFilters($qb);
        $qb = $this->search($qb);
        $orders = $qb->get();
        return $orders;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $order = Order::findOrFail($id);
        return $order;
    }

    /**
     * @param array $data
     * @return \App\Order
     * @throws \Exception
     */
    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $order = new \App\Order();
            $order->fill($data);
            $order->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $order;
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
            $order = $this->findOne($id);
            $order->fill($data);
            $order->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $order;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        \DB::beginTransaction();
        try {
            $order = $this->findOne($id);
            $order->delete();
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
        if (Input::has('search')) {
            $value = Input::get('search');

            $queryBuilder->select(['orders.*']);

            if (!$this->isJoined($queryBuilder, 'addresses')) {
                $queryBuilder->leftJoin('addresses', 'orders.address_id', '=', 'addresses.id');
            }
            $queryBuilder
                ->orWhere('addresses.address_1', 'like', '%'.$value.'%')
                ->orWhere('addresses.address_2', 'like', '%'.$value.'%')
                ->orWhere('addresses.town', 'like', '%'.$value.'%')
                ->orWhere('addresses.county', 'like', '%'.$value.'%')
                ->orWhere('addresses.postcode', 'like', '%'.$value.'%');

            if (!$this->isJoined($queryBuilder, 'customers')) {
                $queryBuilder->leftJoin('customers', 'orders.customer_id', '=', 'customers.id');
            }
            $queryBuilder
                ->orWhere('customers.firstname', 'like', '%'.$value.'%')
                ->orWhere('customers.surname', 'like', '%'.$value.'%');

            if (!$this->isJoined($queryBuilder, 'order_statuses')) {
                $queryBuilder->leftJoin('order_statuses', 'orders.status_id', '=', 'order_statuses.id');
            }
            $queryBuilder->orWhere('order_statuses.name', 'like', '%'.$value.'%');


            /**
             * @todo Implement searching by price on order listing
             */
//            if (!$this->isJoined($queryBuilder, 'order_product')) {
//                $queryBuilder->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id');
//            }
//            if (!$this->isJoined($queryBuilder, 'products')) {
//                $queryBuilder->leftJoin('products', 'products.id', '=', 'order_product.product_id');
//            }
//            $queryBuilder->orWhere(\DB::raw("sum(products.price)"), 'like', '%'.$value.'%');

        }

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
                case 'value':
                    $queryBuilder
                        ->select(['orders.*'])
                        ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
                        ->leftJoin('products', 'products.id', '=', 'order_product.product_id')
                        ->groupBy('orders.id')
                        ->orderBy(\DB::raw("sum(products.price)"), $orderDirection);
                    break;

                case 'status':
                    $queryBuilder
                        ->select(['orders.*'])
                        ->leftJoin('order_statuses', 'orders.status_id', '=', 'order_statuses.id')
                        ->orderBy('order_statuses.name', $orderDirection);

                case 'customer':
                    $queryBuilder
                        ->select(['orders.*'])
                        ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
                        ->orderBy('customers.firstname', $orderDirection);
                    break;

                case 'address':
                    $queryBuilder
                        ->select(['orders.*'])
                        ->leftJoin('addresses', 'orders.address_id', '=', 'addresses.id')
                        ->orderBy('addresses.address_1', $orderDirection);
                    break;

                default:
                    $queryBuilder
                        ->select(['orders.*'])
                        ->orderBy($orderBy, $orderDirection);
                    break;
            }
        } else {
            $queryBuilder->orderBy('orders.created_at', 'DESC');
        }
        return $queryBuilder;
    }

}
