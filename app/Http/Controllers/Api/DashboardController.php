<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
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
     * OrderController constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
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

        $orderFilters = [
            'all' => [],
            'new' => ['processed' => 0, 'delivered' => 0],
            'processed' => ['processed' => 1, 'delivered' => 0],
            'delivered' => ['processed' => 1, 'delivered' => 1]
        ];


        foreach ($orderFilters as $orderKey => $filter) {
            Input::merge($filter);

            foreach ($dateRanges as $dateKey => $dateRange) {
                if ($dateKey != 'all') {
                    Input::merge(['between' => $dateRange['start'].'/'.$dateRange['end']]);
                }
                $orders = $this->orderService->findAll();
                $data['orders'][$orderKey][$dateKey] = $orders;
            }
        }

        return response()->json($data);
    }


}
