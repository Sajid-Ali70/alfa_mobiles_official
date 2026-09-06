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

        $brandId = $request->query('brand');
        $seriesId = $request->query('series');

        $query = DB::table('mobiles');

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        if ($seriesId && $seriesId !== 'all') {
            $query->where('series_id', $seriesId);
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

        return view('frontend.shop', compact('settings', 'brands', 'mobiles', 'series', 'brandId', 'seriesId', 'seriesName'));
    }

    public function plan(Request $request)
    {
        $id = $request->query('id');
        $mobile = DB::table('mobiles')->where('id', $id)->first();
        if (!$mobile) return redirect()->route('shop');

        $settings = DB::table('app_settings')->where('id', 1)->first();
        Session::put('order_mobile_id', $id);
        return view('frontend.plan', compact('settings', 'mobile'));
    }

    public function customerInfo(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        // Capture plan details from request if any, or just proceed
        Session::put('order_color', $request->color);
        Session::put('order_tenure', $request->tenure);
        Session::put('order_emi', $request->emi);
        Session::put('order_total', $request->total);

        return view('frontend.customer_info', compact('settings'));
    }

    public function agreement(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        // Save customer info to session
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
            'tenure' => Session::get('order_tenure'),
            'monthly_emi' => Session::get('order_emi'),
            'total_price' => Session::get('order_total'),
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Session::forget(['order_mobile_id', 'order_color', 'order_tenure', 'order_emi', 'order_total', 'order_customer']);

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
}
