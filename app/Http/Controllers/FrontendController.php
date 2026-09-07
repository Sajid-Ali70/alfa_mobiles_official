<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index()
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        return view('frontend.index', compact('settings'));
    }

    public function shop(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        $brands = DB::table('brands')->get();

        // Safety check for storages table
        $storages = [];
        try {
            $storages = DB::table('storages')->get();
        } catch (\Exception $e) {}

        $brandId = $request->query('brand');
        $seriesId = $request->query('series');
        $storageId = $request->query('storage');

        $query = DB::table('mobiles');

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        if ($seriesId && $seriesId !== 'all') {
            $query->where('series_id', $seriesId);
        }

        if ($storageId && $storageId !== 'all') {
            $query->where('storage_id', $storageId);
        }

        $mobiles = $query->get();

        // Get series based on selected brand
        $seriesQuery = DB::table('series');
        if ($brandId) {
            $seriesQuery->where('brand_id', $brandId);
        }
        $series = $seriesQuery->get();

        $seriesName = 'All Series';
        if ($seriesId && $seriesId !== 'all') {
            $selectedSeries = DB::table('series')->where('id', $seriesId)->first();
            $seriesName = $selectedSeries ? $selectedSeries->name : 'All Series';
        }

        return view('frontend.shop', compact('settings', 'brands', 'mobiles', 'series', 'storages', 'brandId', 'seriesId', 'storageId', 'seriesName'));
    }

    public function plan(Request $request)
    {
        $id = $request->query('id');

        $mobileQuery = DB::table('mobiles')->where('mobiles.id', $id);

        // Try to join storages if column exists
        try {
            $mobile = $mobileQuery->leftJoin('storages', 'mobiles.storage_id', '=', 'storages.id')
                ->select('mobiles.*', 'storages.name as storage_name')
                ->first();
        } catch (\Exception $e) {
            $mobile = $mobileQuery->first();
        }

        if (!$mobile) return redirect()->route('shop');

        $settings = DB::table('app_settings')->where('id', 1)->first();
        Session::put('order_mobile_id', $id);
        return view('frontend.plan', compact('settings', 'mobile'));
    }

    public function customerInfo(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        Session::put('order_color', $request->color);
        Session::put('order_storage', $request->storage);
        Session::put('order_tenure', $request->tenure);
        Session::put('order_emi', $request->emi);
        Session::put('order_total', $request->total);

        return view('frontend.customer_info', compact('settings'));
    }

    public function agreement(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        Session::put('order_customer', $request->all());
        return view('frontend.agreement', compact('settings'));
    }

    public function submitOrder(Request $request)
    {
        $mobileId = Session::get('order_mobile_id');
        $customer = Session::get('order_customer');

        $orderNumber = 'AM-' . date('ymd') . '-' . rand(1000, 9999);

        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $fileName = 'proof_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/proofs'), $fileName);
            $proofPath = '/uploads/proofs/' . $fileName;
        }

        DB::table('orders')->insert([
            'order_number' => $orderNumber,
            'full_name' => $customer['full_name'] ?? 'N/A',
            'cnic' => $customer['cnic'] ?? 'N/A',
            'mobile_number' => $customer['mobile_number'] ?? 'N/A',
            'address' => $customer['address'] ?? 'N/A',
            'delivery_type' => $customer['delivery_type'] ?? 'N/A',
            'payment_method' => $request->payment_method,
            'wallet_service' => $request->wallet_service,
            'account_holder' => $request->account_holder,
            'proof_image' => $proofPath,
            'mobile_id' => $mobileId,
            'color' => Session::get('order_color'),
            'storage' => Session::get('order_storage'),
            'tenure' => Session::get('order_tenure'),
            'monthly_emi' => Session::get('order_emi'),
            'total_price' => Session::get('order_total'),
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Session::forget(['order_mobile_id', 'order_color', 'order_storage', 'order_tenure', 'order_emi', 'order_total', 'order_customer']);

        return response()->json(['success' => true, 'order_number' => $orderNumber]);
    }

    public function track()
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        return view('frontend.track', compact('settings'));
    }

    public function checkStatus(Request $request)
    {
        $query = DB::table('orders');
        if ($request->order_id) {
            $query->where('order_number', $request->order_id);
        } else if ($request->mobile_number) {
            $query->where('mobile_number', $request->mobile_number);
        } else {
            return back()->with('error', 'Please enter Order ID or Mobile Number');
        }

        $order = $query->first();
        if (!$order) return back()->with('error', 'Order not found');

        $settings = DB::table('app_settings')->where('id', 1)->first();
        return view('frontend.track_result', compact('settings', 'order'));
    }

    public function refund()
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        return view('frontend.refund', compact('settings'));
    }

    public function refundAgreement(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        Session::put('refund_details', $request->all());
        return view('frontend.refund_agreement', compact('settings'));
    }

    public function submitRefund(Request $request)
    {
        $details = Session::get('refund_details');

        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $fileName = 'refund_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/refunds'), $fileName);
            $proofPath = '/uploads/refunds/' . $fileName;
        }

        $refundId = 'RRF-' . date('Ymd') . '-' . rand(100000, 999999);

        DB::table('refund_requests')->insert([
            'refund_id' => $refundId,
            'customer_name' => $details['customer_name'] ?? 'N/A',
            'order_id' => $details['order_id'] ?? 'N/A',
            'refund_amount' => $details['refund_amount'] ?? 0,
            'payment_method' => $request->payment_method ?? 'N/A',
            'proof_image' => $proofPath,
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Session::forget('refund_details');

        return response()->json(['success' => true, 'refund_id' => $refundId]);
    }

    public function refundSuccess(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        $refund_id = $request->query('refund_id');
        $refund = DB::table('refund_requests')->where('refund_id', $refund_id)->first();
        return view('frontend.refund_success', compact('settings', 'refund'));
    }

    public function calculator()
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        $brands = DB::table('brands')->get();
        return view('frontend.calculator', compact('settings', 'brands'));
    }

    public function getModels($brandId)
    {
        $mobiles = DB::table('mobiles')
            ->leftJoin('storages', 'mobiles.storage_id', '=', 'storages.id')
            ->leftJoin('series', 'mobiles.series_id', '=', 'series.id')
            ->where('mobiles.brand_id', $brandId)
            ->select('mobiles.*', 'storages.name as storage_name', 'series.name as series_name', 'series.id as series_id')
            ->get();
        return response()->json($mobiles);
    }
}
