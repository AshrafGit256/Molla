<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentIconModel;
use Illuminate\Support\Str;

class PaymentIconController extends Controller
{
    public function list()
    {
        $data['getRecord'] = PaymentIconModel::orderBy('order_by', 'asc')->get();
        $data['header_title'] = 'Payment Icons';
        return view('admin.payment_icon.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add Payment Icon';
        return view('admin.payment_icon.add', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        $save = new PaymentIconModel;
        $save->order_by = PaymentIconModel::count() + 1;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move(public_path('upload/payment_icons/'), $filename);
            $save->image_name = trim($filename);
        }

        $save->save();

        return redirect('admin/payment-icon/list')->with('success', "Payment Icon Added");
    }

    public function edit($id)
    {
        $data['getRecord'] = PaymentIconModel::find($id);
        $data['header_title'] = 'Edit Payment Icon';
        return view('admin.payment_icon.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $save = PaymentIconModel::find($id);

        $save->order_by = $request->order_by ?? $save->order_by;

        if ($request->hasFile('image')) {
            if (!empty($save->image_name) && file_exists('upload/payment_icons/' . $save->image_name)) {
                unlink('upload/payment_icons/' . $save->image_name);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(10);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move(public_path('upload/payment_icons/'), $filename);
            $save->image_name = trim($filename);
        }

        $save->save();

        return redirect('admin/payment-icon/list')->with('success', "Payment Icon Updated");
    }

    public function delete($id)
    {
        $getRecord = PaymentIconModel::find($id);

        if (!empty($getRecord->image_name) && file_exists('upload/payment_icons/' . $getRecord->image_name)) {
            unlink('upload/payment_icons/' . $getRecord->image_name);
        }

        $getRecord->delete();

        return redirect()->back()->with('success', "Payment Icon Deleted");
    }

    public function sort(Request $request)
    {
        foreach ($request->sort as $id => $order) {
            PaymentIconModel::where('id', $id)->update(['order_by' => $order]);
        }

        return response()->json(['status' => true, 'message' => 'Order updated']);
    }
}
