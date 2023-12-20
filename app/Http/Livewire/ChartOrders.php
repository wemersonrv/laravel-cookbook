<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class ChartOrders extends Component
{
    public $thisYearOrders;
    public $lastYearOrders;

    public function mount()
    {
        $this->updateOrdersCount();
    }

    public function updateOrdersCount()
    {
        $this->thisYearOrders = Order::getYearOrders(date('Y'))->groupByMonth();
        $this->lastYearOrders = Order::getYearOrders(date('Y') -1)->groupByMonth();
    }

    public function render()
    {
        $availableYears = [
          date('Y'),
          date('Y') - 1,
          date('Y') - 2,
          date('Y') - 3,
        ];

        return view('livewire.chart-orders', [
          'availableYears' => $availableYears,
        ]);
    }
}
