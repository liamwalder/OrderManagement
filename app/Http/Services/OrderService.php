<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;
use App\Http\Transformers\OrderTransformer;
use App\Order;
use Illuminate\Events\Dispatcher;

/**
 * Class OrderService
 * @package App\Http\Services
 */
class OrderService extends Service
{

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var OrderTransformer
     */
    private $orderTransformer;

    /**
     * OrderService constructor.
     * @param Dispatcher $dispatcher
     * @param OrderRepository $orderRepository
     * @param OrderTransformer $orderTransformer
     */
    public function __construct(
        Dispatcher $dispatcher,
        OrderRepository $orderRepository,
        OrderTransformer $orderTransformer
    ) {
        $this->dispatcher = $dispatcher;
        $this->orderRepository = $orderRepository;
        $this->orderTransformer = $orderTransformer;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $order = $this->orderRepository->findOne($id);
        $order = $this->orderTransformer->transformItem($order);
        return $order;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $orders = $this->orderRepository->findAll();
        $orders = $this->orderTransformer->transformCollection($orders);

        $pagination = $this->pagination(Order::class);

        return ['items' => $orders, 'pagination' => $pagination];
    }

    /**
     * @param array $data
     * @return \App\Order
     * @throws \Exception
     */
    public function create(array $data)
    {
        // Placed
        $data['status_id'] = 1;
        $data['total'] = $this->calculateTotal($data['products']);

        $order = $this->orderRepository->create($data);
        $order->products()->attach($this->manageOrderProducts($data['products']));
        $order->stages()->attach(1);
        $order = $this->orderTransformer->transformItem($order);

        return $order;
    }


    /**
     * @param $id
     * @param array $data
     * @return array|mixed
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        if (isset($data['products'])) {
            $data['total'] = $this->calculateTotal($data['products']);
        }
        
        $order = $this->orderRepository->update($id, $data);

        if (isset($data['products'])) {
            $order->products()->detach();
            $order->products()->attach($this->manageOrderProducts($data['products']));
        }

        if (isset($data['status'])) {
            $order->stages()->attach($data['status']);
        }

        $order = $this->orderTransformer->transformItem($order);
        return $order;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->orderRepository->delete($id);
    }


    /**
     * @param $orderProducts
     * @return int
     */
    protected function calculateTotal($orderProducts)
    {
        $total = 0;
        foreach ($orderProducts as $product) {
            $total += ($product['quantity'] * $product['price']);
        }
        return $total;
    }

    /**
     * @param $orderProducts
     * @return mixed
     */
    protected function manageOrderProducts($orderProducts)
    {
        $products = [];
        foreach ($orderProducts as $product) {
            $productId = $product['id'];
            $quantity = $product['quantity'];
            for ($i = 0; $i < $quantity; $i++) {
                $products[] = $productId;
            }
        }
        return $products;
    }

}