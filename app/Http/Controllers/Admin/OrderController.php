<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\NotificationModel;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusMail;

class OrderController extends Controller
{
    public function list()
    {
        $data['getRecord'] = OrderModel::getRecord();
        $data['header_title'] = 'Orders';
        return view('admin.order.list', $data);
    }

    public function order_detail($id, Request $request)
    {
        if(!empty($request->notify_id))
        {
            // NotificationModel::updateReadNotify($request->notify_id);
        }
        $data['getRecord'] = OrderModel::getSingle($id);
        $data['header_title'] = 'Order Detail';
        $data['getRiderList'] = \App\Models\User::where('is_delivery', 1)
            ->where('is_delete', 0)
            ->orderBy('name', 'asc')
            ->get();
        return view('admin.order.detail', $data);
    }

    public function assign_rider(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'rider_id' => 'nullable|integer|exists:users,id',
        ]);

        $order = OrderModel::getSingle($request->order_id);
        if (empty($order)) {
            return response()->json(['status' => false, 'message' => 'Order not found.']);
        }

        if (!empty($request->rider_id)) {
            $rider = \App\Models\User::where('id', $request->rider_id)
                ->where('is_delivery', 1)
                ->where('is_delete', 0)
                ->first();

            if (empty($rider)) {
                return response()->json(['status' => false, 'message' => 'Invalid rider selected.']);
            }

            $order->rider_id = $rider->id;
            $order->rider_name = $rider->name;
        } else {
            $order->rider_id = null;
            $order->rider_name = null;
        }

        $order->save();

        return response()->json(['status' => true, 'message' => 'Rider updated successfully.']);
    }

    public function order_status(Request $request)
    {
        $getOrder = OrderModel::getSingle($request -> order_id);

        if ($getOrder->status != (int)$request->status) {
            $getOrder->status = $request->status;

            if ((int)$request->status === 2 && !empty($getOrder->rider_id)) {
                $rider = \App\Models\User::find($getOrder->rider_id);
                if (!empty($rider)) {
                    $getOrder->rider_name = $rider->name;
                }
            }

            $getOrder->save();
        }

        $user_id = $getOrder->user_id;
        $url = url('user/order');
        $message = "Your Order Status has been sucessfully updated #".$getOrder->order_number;

        // NotificationModel::insertRecord($user_id, $url, $message);

        // Mail::to($getOrder->email)->send(new OrderStatusMail($getOrder));

        $json['message'] = "Status successfully updated";
        echo json_encode($json);
    }

}
