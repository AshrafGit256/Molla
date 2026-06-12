<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProductModel;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $data['TotalOrder'] = OrderModel::getTotalOrder();
        $data['TotalTodayOrder'] = OrderModel::getTotalTodayOrder();
        $data['TotalAmount'] = OrderModel::getTotalAmount();
        $data['TotalTodayAmount'] = OrderModel::getTotalTodayAmount();
        $data['TotalProfit'] = OrderModel::getProfitTotal();
        $data['todayProfit'] = OrderModel::getProfitToday();
        $data['TotalCustomer'] = User::getTotalCustomer();
        $data['TotalTodayCustomer'] = User::getTotalTodayCustomer();

        $data['getLatestOrders'] = OrderModel::getLatestOrders();
        $data['pendingOrders'] = OrderModel::where('is_payment', 1)
            ->where('is_delete', 0)
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        $data['orderStatusCounts'] = [
            'pending' => OrderModel::where('is_payment', 1)->where('is_delete', 0)->where('status', 0)->count(),
            'in_progress' => OrderModel::where('is_payment', 1)->where('is_delete', 0)->where('status', 1)->count(),
            'delivered' => OrderModel::where('is_payment', 1)->where('is_delete', 0)->where('status', 2)->count(),
            'completed' => OrderModel::where('is_payment', 1)->where('is_delete', 0)->where('status', 3)->count(),
            'cancelled' => OrderModel::where('is_payment', 1)->where('is_delete', 0)->where('status', 4)->count(),
        ];
        $data['oneHourOrders'] = OrderModel::where('is_payment', 1)
            ->where('is_delete', 0)
            ->whereNotNull('delivery_duration_minutes')
            ->where('delivery_duration_minutes', '<=', 60)
            ->count();
        $data['farDeliveryOrders'] = OrderModel::where('is_payment', 1)
            ->where('is_delete', 0)
            ->where('delivery_duration_minutes', '>', 60)
            ->count();
        $data['averageDeliveryMinutes'] = round((float) OrderModel::where('is_payment', 1)
            ->where('is_delete', 0)
            ->whereNotNull('delivery_duration_minutes')
            ->avg('delivery_duration_minutes'));
        $data['averageOrderValue'] = $data['TotalOrder'] > 0 ? $data['TotalAmount'] / $data['TotalOrder'] : 0;
        $data['activeProductCount'] = ProductModel::where('is_delete', 0)->where('status', 0)->count();
        $data['totalUnitsInStock'] = ProductModel::where('is_delete', 0)->where('status', 0)->sum('in_stock');
        $data['totalUnitsSold'] = ProductModel::where('is_delete', 0)->sum('out_of_stock');
        $data['lowStockProducts'] = ProductModel::where('is_delete', 0)
            ->where('status', 0)
            ->where('in_stock', '<=', 10)
            ->orderBy('in_stock', 'asc')
            ->limit(5)
            ->get();
        $data['missingImageProducts'] = ProductModel::where('is_delete', 0)
            ->where('status', 0)
            ->whereDoesntHave('getImage')
            ->limit(5)
            ->get();
        $data['recentCustomers'] = User::where('is_admin', 0)
            ->where('is_delete', 0)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $request->validate([
            'profit_from' => 'nullable|date',
            'profit_to' => 'nullable|date|after_or_equal:profit_from',
        ]);

        $profitFrom = $request->input('profit_from') ?: null;
        $profitTo = $request->input('profit_to') ?: null;

        if (empty($profitFrom) && empty($profitTo)) {
            $profitFrom = date('Y-m-01');
            $profitTo = date('Y-m-t');
        } elseif (empty($profitTo)) {
            $profitTo = $profitFrom ?: date('Y-m-d');
        }

        if (empty($profitFrom)) {
            $profitFrom = date('Y-m-01', strtotime($profitTo));
        }

        $data['profitFrom'] = $profitFrom;
        $data['profitTo'] = $profitTo;
        $data['profitRange'] = OrderModel::getProfitRange($profitFrom, $profitTo);
        $data['weekProfit'] = OrderModel::getProfitRange(
            date('Y-m-d', strtotime('monday this week')),
            date('Y-m-d', strtotime('sunday this week'))
        );
        $data['todayProfit'] = OrderModel::getProfitToday();

        $data['productProfit'] = ProductModel::select(
                'product.id',
                'product.title',
                'product.bought_at',
                \DB::raw('SUM(orders_item.quantity) as total_quantity'),
                \DB::raw('SUM(orders_item.price * orders_item.quantity) as total_revenue'),
                \DB::raw('SUM(IFNULL(product.bought_at, 0) * orders_item.quantity) as total_cost'),
                \DB::raw('SUM(orders_item.quantity * (orders_item.price - IFNULL(product.bought_at, 0))) as total_profit')
            )
            ->join('orders_item', 'product.id', '=', 'orders_item.product_id')
            ->join('orders', 'orders.id', '=', 'orders_item.order_id')
            ->where('orders.is_payment', 1)
            ->where('orders.is_delete', 0)
            ->whereDate('orders.created_at', '>=', $profitFrom)
            ->whereDate('orders.created_at', '<=', $profitTo)
            ->groupBy('product.id', 'product.title', 'product.bought_at')
            ->orderBy('total_profit', 'desc')
            ->get();

        if(!empty($request->year))
        {
            $year = $request->year;
        }
        else
        {
            $year = date('Y');
        }

        $getTotalCustomerMonth = '';
        $getTotalOrderMonth = '';
        $getTotalOrderAmountMonth = '';

        $totalAmount = 0;

        for($month = 1; $month <= 12; $month++)
        {
            $startDate = new \DateTime("$year-$month-01");
            $endDate = new \DateTime("$year-$month-01");
            $endDate->modify('last day of this month');

            $start_date = $startDate->format('Y-m-d');
            $end_date = $endDate->format('Y-m-d');

            $customer = User::getTotalCustomerMonth($start_date, $end_date);
            $getTotalCustomerMonth .= $customer . ',';

            $order = OrderModel::getTotalOrderMonth($start_date, $end_date);
            $getTotalOrderMonth .= $order . ',';

            $order_payment = OrderModel::getTotalOrderAmountMonth($start_date, $end_date);
            $getTotalOrderAmountMonth .= $order_payment . ',';

            $totalAmount = $totalAmount + $order_payment;
        }

        $data['getTotalCustomerMonth'] = rtrim($getTotalCustomerMonth, ",");
        $data['getTotalOrderMonth'] = rtrim($getTotalOrderMonth, ",");
        $data['getTotalOrderAmountMonth'] = rtrim($getTotalOrderAmountMonth, ",");

        $data['totalAmount'] = $totalAmount;
        $data['year'] = $year;


        $data['header_title'] = "Dashboard";
        
        return view('admin.dashboard', $data);
    }
}
