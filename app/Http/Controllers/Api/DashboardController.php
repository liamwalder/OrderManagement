<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\OrderRepository;
use App\Http\Services\OrderService;
use App\Order;
use App\Product;
use App\Stage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Api
 */
class DashboardController extends Controller
{

    /**
     * @var OrderService
     */
    public $orderService;

    /**
     * @var OrderRepository
     */
    public $orderRepository;

    /**
     * DashboardController constructor.
     * @param OrderService $orderService
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        OrderService $orderService,
        OrderRepository $orderRepository
    )
    {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function statisticPanel()
    {
        $data = [];
        $carbon = new Carbon();

        $dateRanges = [
            'all' => [],
            'today' => [
                'start' => $carbon->copy()->format('Y-m-d') . ' 00:00:00',
                'end' => $carbon->copy()->format('Y-m-d') . ' 23:23:59'
            ],
            'week' => [
                'start' => $carbon->copy()->startOfWeek()->format('Y-m-d') . ' 00:00:00',
                'end' => $carbon->copy()->endOfWeek()->format('Y-m-d') . ' 23:23:59',
            ],
            'month' => [
                'start' => $carbon->copy()->startOfMonth()->format('Y-m-d') . ' 00:00:00',
                'end' => $carbon->copy()->endOfMonth()->format('Y-m-d') . ' 23:23:59',
            ]
        ];

       foreach (Stage::all() as $stage) {
           foreach ($dateRanges as $dateKey => $dateRange) {

               if ($dateKey == 'all') {
                   $orderProducts = \DB::select('SELECT * from order_stage WHERE stage_id = ?', [$stage->id]);
               } else {
                   $orderProducts = \DB::select('SELECT * from order_stage WHERE stage_id = ? AND created_at BETWEEN ? AND ?', [$stage->id, $dateRange['start'], $dateRange['end']]);
               }


               $orderIds = [];
               foreach ($orderProducts as $key => $orderProduct) {
                   $orderIds[] = $orderProduct->order_id;
               }

               Input::merge(['in' => $orderIds]);
               $orders = $this->orderService->findAll();

               $data['orders'][strtolower($stage->name)][$dateKey] = $orders;
           }
       }


        return response()->json($data);
    }


}
