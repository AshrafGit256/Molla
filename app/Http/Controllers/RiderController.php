<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\NotificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiderController extends Controller
{
    public function dashboard()
    {
        $data['meta_title'] = 'Rider Dashboard';
        $data['assignedOrders'] = OrderModel::where('rider_id', Auth::id())
            ->where('is_payment', 1)
            ->where('is_delete', 0)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $data['activeOrders'] = OrderModel::where('rider_id', Auth::id())
            ->where('is_payment', 1)
            ->where('is_delete', 0)
            ->whereIn('status', [0, 1])
            ->orderBy('id', 'desc')
            ->get();

        return view('rider.dashboard', $data);
    }

    public function orders(Request $request)
    {
        $query = OrderModel::where('rider_id', Auth::id())
            ->where('is_payment', 1)
            ->where('is_delete', 0);

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        $data['getRecord'] = $query->orderBy('id', 'desc')->paginate(20);
        $data['meta_title'] = 'Rider Orders';
        return view('rider.orders', $data);
    }

    public function order_detail($id)
    {
        $order = OrderModel::where('rider_id', Auth::id())
            ->where('id', $id)
            ->where('is_payment', 1)
            ->where('is_delete', 0)
            ->first();

        if (empty($order)) {
            abort(404);
        }

        $systemSetting = \App\Models\SystemSettingModel::getSingle();
        $data['storeLatitude'] = !empty($systemSetting->store_latitude) ? $systemSetting->store_latitude : 0;
        $data['storeLongitude'] = !empty($systemSetting->store_longitude) ? $systemSetting->store_longitude : 0;
        $data['getRecord'] = $order;
        $data['meta_title'] = 'Order Detail';
        return view('rider.order_detail', $data);
    }

    public function update_status(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'status' => 'required|integer|in:1,2,4',
        ]);

        $order = OrderModel::where('rider_id', Auth::id())
            ->where('id', $request->order_id)
            ->where('is_payment', 1)
            ->where('is_delete', 0)
            ->first();

        if (empty($order)) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found or not assigned to you.',
            ]);
        }

        $order->status = $request->status;
        $order->save();

        $statusText = match ($request->status) {
            1 => 'In Progress',
            2 => 'Delivered',
            4 => 'Returned',
            default => 'Updated',
        };

        return response()->json([
            'status' => true,
            'message' => "Order marked as {$statusText}.",
        ]);
    }

    public function notify_customer(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
        ]);

        $order = OrderModel::where('rider_id', Auth::id())
            ->where('id', $request->order_id)
            ->where('is_payment', 1)
            ->where('is_delete', 0)
            ->first();

        if (empty($order)) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found or not assigned to you.',
            ]);
        }

        $order->delivery_started_at = now();
        $order->save();

        $url = url('user/orders/detail/' . $order->id);
        $message = "Rider has started moving for order #{$order->order_number}. Track your delivery!";
        NotificationModel::insertRecord($order->user_id, $url, $message);

        return response()->json([
            'status' => true,
            'message' => 'Customer notified successfully.',
        ]);
    }
}
