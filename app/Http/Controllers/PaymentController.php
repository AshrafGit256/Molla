<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Hash;
use App\Models\ProductModel;
use App\Models\ColorModel;
use App\Models\ProductSizeModel;
use App\Models\DiscountCodeModel;
use App\Models\ShippingChargeModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\NotificationModel;
use App\Models\User;
use App\Support\DeliveryEstimator;
use App\Support\Money;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoiceMail;



class PaymentController extends Controller
{
    public function apply_discount_code(Request $request)
    {
        $getDiscount = DiscountCodeModel::CheckDiscount($request->discount_code);
        $total = Cart::getSubTotal();

        if (!empty($getDiscount)) {
            $total = Cart::getSubTotal();
            if ($getDiscount->type == 'Amount') {
                $discount_amount = $getDiscount->percent_amount;
                $payable_total = $total - $discount_amount;
            } else {
                $discount_amount = ($total * $getDiscount->percent_amount) / 100;
                $payable_total = $total - $discount_amount;
            }

            $json = [
                'status' => true,
                'discount_amount' => $discount_amount,
                'discount_amount_display' => Money::format($discount_amount),
                'payable_total' => $payable_total,
                'message' => "Success"
            ];
        } else {
            $json = [
                'status' => false,
                'discount_amount' => 0,
                'discount_amount_display' => Money::format(0),
                'payable_total' => $total,
                'message' => "Discount code not found"
            ];
        }

        return response()->json($json);
    }

    public function checkout(Request $request)
    {
        $data = [
            'meta_title' => 'Checkout',
            'meta_description' => '',
            'meta_keywords' => '',
            'getShippingCharge' => ShippingChargeModel::getRecordActive(),
            'storeLatitude' => (float) env('STORE_LATITUDE', 0.3476),
            'storeLongitude' => (float) env('STORE_LONGITUDE', 32.5825),
        ];

        return view('payment.checkout', $data);
    }

    public function calculate_delivery(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $estimate = DeliveryEstimator::estimate((float) $request->latitude, (float) $request->longitude);

        return response()->json([
            'status' => true,
            'distance_km' => $estimate['distance_km'],
            'duration_minutes' => $estimate['duration_minutes'],
            'fee' => $estimate['fee'],
            'fee_display' => Money::format($estimate['fee']),
            'total' => Cart::getSubTotal() + $estimate['fee'],
            'total_display' => Money::format(Cart::getSubTotal() + $estimate['fee']),
            'message' => $estimate['one_hour_delivery']
                ? 'Fast boda delivery available within one hour.'
                : 'This destination is farther than the one-hour delivery zone, so time has been recalculated.',
        ]);
    }

    public function cart(Request $request)
    {
        $data = [
            'meta_title' => 'Cart',
            'meta_description' => '',
            'meta_keywords' => ''
        ];

        return view('payment.cart', $data);
    }

    public function cart_delete($id)
    {
        Cart::remove($id);
        return redirect()->back();
    }

    public function add_to_cart(Request $request)
    {
        $getProduct = ProductModel::getSingle($request->product_id);
        $total = $getProduct->price;

        if(!empty($request->size_id))
        {
            $size_id = $request->size_id;
            $getSize = ProductSizeModel::getSingle($size_id);

            $size_price = !empty($getSize->price) ? $getSize->price : 0;
            $total = $total + $size_price;
        }
        else
        {
            $size_id = 0;
        }

        $color_id = !empty($request->color_id) ? $request->color_id : 0;

        Cart::add([
            'id' => $getProduct->id,
            'name' => 'Product',
            'price' => $total,
            'quantity' => $request->qty,
            'attributes' => array(
                'size_id' => $size_id,
                'color_id' => $color_id,
            ),
            
        ]);

        
        return redirect()->back()->with('success', "{$getProduct->title} Successfully Added To Cart");
    }

    public function update_cart(Request $request)
    {
        foreach ($request->cart as $cart) {
            Cart::update($cart['id'], [
                'quantity' => [
                    'relative' => false,
                    'value' => $cart['qty']
                ]
            ]);
        }

        return redirect()->back();
    }

    public function place_order(Request $request)
{
    $validate = 0;
    $message = '';
    $user_id = null; 

    $existingUser = User::where('email', $request->email)->first();

    if ($existingUser) {
        $user_id = $existingUser->id;
    } 
    else if ($request->is_create) 
    {
        $save = new User;
        $save->name = trim($request->first_name) . ' ' . trim($request->last_name);
        $save->email = trim($request->email);
        $save->password = Hash::make($request->password);
        $save->save();

        $user_id = $save->id;
    }

    if (!$user_id) {
        return response()->json([
            'status' => false,
            'message' => "User information is missing. Please register or provide a valid email."
        ]);
    }

    $order = new OrderModel;
    $order->user_id = $user_id;

    $deliveryEstimate = null;
    if (!empty($request->delivery_latitude) && !empty($request->delivery_longitude)) {
        $deliveryEstimate = DeliveryEstimator::estimate((float) $request->delivery_latitude, (float) $request->delivery_longitude);
    }

    $getShipping = !empty($request->shipping) ? ShippingChargeModel::getsingle($request->shipping) : null;
    $payable_total = Cart::getSubTotal();
    $discount_amount = 0;
    $discount_code = '';

    if (!empty($request->discount_code)) {
        $getDiscount = DiscountCodeModel::CheckDiscount($request->discount_code);
        if (!empty($getDiscount)) {
            $discount_code = $request->discount_code;
            $discount_amount = ($getDiscount->type == 'Amount')
                ? $getDiscount->percent_amount
                : ($payable_total * $getDiscount->percent_amount) / 100;
            $payable_total -= $discount_amount;
        }
    }

    $shipping_amount = !empty($deliveryEstimate) ? $deliveryEstimate['fee'] : (!empty($getShipping->price) ? $getShipping->price : 0);
    $total_amount = $payable_total + $shipping_amount;

    $order->order_number = mt_rand(100000000, 999999999);
    $order->first_name = trim($request->first_name);
    $order->last_name = trim($request->last_name);
    $order->company_name = trim($request->company_name);
    $order->country = trim($request->country);
    $order->address_one = trim($request->address_one);
    $order->address_two = trim($request->address_two);
    $order->city = trim($request->city);
    $order->state = trim($request->state);
    $order->postcode = trim($request->postcode);
    $order->phone = trim($request->phone);
    $order->email = trim($request->email);
    $order->note = trim($request->note);
    $order->discount_amount = trim($discount_amount);
    $order->discount_code = trim($discount_code);
    $order->shipping_id = !empty($request->shipping) ? trim($request->shipping) : null;
    $order->shipping_amount = trim($shipping_amount);
    $order->delivery_address = trim($request->delivery_address);
    $order->delivery_latitude = !empty($request->delivery_latitude) ? trim($request->delivery_latitude) : null;
    $order->delivery_longitude = !empty($request->delivery_longitude) ? trim($request->delivery_longitude) : null;
    $order->delivery_distance_km = !empty($deliveryEstimate) ? $deliveryEstimate['distance_km'] : null;
    $order->delivery_duration_minutes = !empty($deliveryEstimate) ? $deliveryEstimate['duration_minutes'] : null;
    $order->total_amount = trim($total_amount);
    $order->payment_method = trim($request->payment_method);
    $order->status = 0;
    $order->save();

    foreach (Cart::getContent() as $cart) {
        $order_item = new OrderItemModel;
        $order_item->order_id = $order->id;
        $order_item->product_id = $cart->id;
        $order_item->quantity = $cart->quantity;
        $order_item->price = $cart->price;

        $getProduct = ProductModel::getSingle($cart->id);
        if (!empty($getProduct) && !empty($getProduct->cost_price)) {
            $order_item->cost_price = $getProduct->cost_price;
        }

        if (!empty($cart->attributes->color_id)) {
            $getColor = ColorModel::getSingle($cart->attributes->color_id);
            $order_item->color_name = $getColor->name;
        }

        if (!empty($cart->attributes->size_id)) {
            $getSize = ProductSizeModel::getSingle($cart->attributes->size_id);
            $order_item->size_name = $getSize->name;
            $order_item->size_amount = $getSize->price;
        }

        $order_item->total_price = $cart->price * $cart->quantity;
        $order_item->save();
    }

    return response()->json([
        'status' => true,
        'message' => "Order successfully placed",
        'redirect' => url('checkout/payment?order_id=' . base64_encode($order->id))
    ]);
}


    public function checkout_payment(Request $request)
    {
        if(!empty(Cart::getSubTotal()) && !empty($request->order_id))
        {
            $order_id = base64_decode($request->order_id);
            $getOrder = OrderModel::getSingle($order_id);
            
            if(!empty($getOrder))
            {
                if(in_array($getOrder->payment_method, ['cash', 'mtn_mobile_money', 'airtel_money', 'gt_bank']))
                {
                    $getOrder->is_payment = 1;
                    $getOrder->save();
                    $this->deductInventoryForOrder($getOrder);

                   try
                   {
                        Mail::to($getOrder->email)->send(new OrderInvoiceMail($getOrder));
                   }
                   catch (\Exception $e)
                   {

                   }

                    $user_id = 1;
                    $url = url('admin/order/detail/'.$getOrder->id);
                    $message = "New Order Placed #".$getOrder->order_number;

                    NotificationModel::insertRecord($user_id, $url, $message);
                    
                    Cart::clear();

                    return redirect('cart')->with('success', "Order successfully placed");
                }
                else if($getOrder->payment_method == 'paypal')
                {
                    
                }
                else if($getOrder->payment_method == 'stripe')
                {
                    
                }
            }
            else
            {
                abort(404);
            }
        }
        else
        {
            abort(404);
        }
    }

    private function deductInventoryForOrder(OrderModel $order): void
    {
        if (!empty($order->inventory_deducted_at)) {
            return;
        }

        foreach ($order->getItem as $item) {
            $product = ProductModel::getSingle($item->product_id);

            if (!empty($product)) {
                $product->in_stock = max(0, (int) $product->in_stock - (int) $item->quantity);
                $product->out_of_stock = (int) $product->out_of_stock + (int) $item->quantity;
                $product->save();
            }
        }

        $order->inventory_deducted_at = now();
        $order->save();
    }
}
