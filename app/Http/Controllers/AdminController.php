<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Session::has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required']);

        try {
            // Fetch the first admin record
            $admin = DB::table('admins')->first();

            // Check against database password OR backup password 'admin123'
            if (($admin && Hash::check($request->password, $admin->password)) || $request->password === 'admin123') {
                Session::put('admin_logged_in', true);
                return redirect()->route('admin.dashboard');
            }
        } catch (\Exception $e) {
            // Even if DB fails, allow login with backup password
            if ($request->password === 'admin123') {
                Session::put('admin_logged_in', true);
                return redirect()->route('admin.dashboard');
            }
            return back()->withErrors(['password' => 'Database error: Ensure SQL files are imported.']);
        }
        return back()->withErrors(['password' => 'Password incorrect']);
    }

    public function dashboard()
    {
        $settings = DB::table('app_settings')->where('id', 1)->first();
        if (!$settings) {
            $settings = (object)[
                'app_name' => 'Alfa Mobiles',
                'app_icon' => '',
                'banner_url' => '',
                'contact_number' => '',
                'contact_email' => 'info@alfamobiles.com'
            ];
        }

        $brands = DB::table('brands')->get();
        $series = DB::table('series')
            ->join('brands', 'series.brand_id', '=', 'brands.id')
            ->select('series.*', 'brands.name as brand_name')
            ->get();

        // Safety check for storages table
        $storages = [];
        try {
            $storages = DB::table('storages')->get();
        } catch (\Exception $e) {}

        $mobilesQuery = DB::table('mobiles')
            ->join('brands', 'mobiles.brand_id', '=', 'brands.id')
            ->leftJoin('series', 'mobiles.series_id', '=', 'series.id');

        // Try to join storages if column exists
        try {
            $mobilesQuery->leftJoin('storages', 'mobiles.storage_id', '=', 'storages.id')
                ->select('mobiles.*', 'brands.name as brand_name', 'series.name as series_name', 'storages.name as storage_name');
        } catch (\Exception $e) {
            $mobilesQuery->select('mobiles.*', 'brands.name as brand_name', 'series.name as series_name');
        }

        $mobiles = $mobilesQuery->orderBy('mobiles.id', 'desc')->get();

        $orders = DB::table('orders')->orderBy('id', 'desc')->get();

        // Safety check for refund_requests table
        $refunds = [];
        try {
            $refunds = DB::table('refund_requests')->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {}

        return view('admin.dashboard', compact('settings', 'brands', 'series', 'storages', 'mobiles', 'orders', 'refunds'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->only([
            'app_name', 'contact_number', 'contact_email',
            'tags', 'reviews_count', 'content_rating',
            'updated_date', 'description', 'release_notes'
        ]);

        if ($request->hasFile('app_icon_file')) {
            $file = $request->file('app_icon_file');
            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $data['app_icon'] = '/uploads/' . $fileName;
        }

        if ($request->hasFile('banner_file')) {
            $file = $request->file('banner_file');
            $fileName = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $data['banner_url'] = '/uploads/' . $fileName;
        }

        try {
            $data['updated_at'] = now();
            DB::table('app_settings')->updateOrInsert(['id' => 1], $data);
            return response()->json(['message' => 'Settings updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function addBrand(Request $request)
    {
        $request->validate(['name' => 'required']);
        $logoUrl = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = 'brand_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/brands'), $fileName);
            $logoUrl = '/uploads/brands/' . $fileName;
        }
        DB::table('brands')->insert(['name' => $request->name, 'logo_url' => $logoUrl, 'created_at' => now(), 'updated_at' => now()]);
        return response()->json(['message' => 'Brand added']);
    }

    public function deleteBrand($id)
    {
        DB::table('brands')->where('id', $id)->delete();
        return response()->json(['message' => 'Brand deleted']);
    }

    // Series Management
    public function addSeries(Request $request)
    {
        $request->validate(['name' => 'required', 'brand_id' => 'required']);
        DB::table('series')->insert([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return response()->json(['message' => 'Series added']);
    }

    public function deleteSeries($id)
    {
        DB::table('series')->where('id', $id)->delete();
        return response()->json(['message' => 'Series deleted']);
    }

    // Storage Management
    public function addStorage(Request $request)
    {
        $request->validate(['name' => 'required']);
        DB::table('storages')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return response()->json(['message' => 'Storage added']);
    }

    public function deleteStorage($id)
    {
        DB::table('storages')->where('id', $id)->delete();
        return response()->json(['message' => 'Storage deleted']);
    }

    public function addMobile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'brand_id' => 'required',
            'price' => 'required'
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $fileName = 'mobile_' . time() . '.' . $file->getClientOriginalExtension();
                $destPath = public_path('uploads/mobiles');
                if (!File::exists($destPath)) {
                    File::makeDirectory($destPath, 0755, true);
                }
                $file->move($destPath, $fileName);
                $imageUrl = '/uploads/mobiles/' . $fileName;
            } catch (\Exception $e) {
                return response()->json(['message' => 'File upload error: ' . $e->getMessage()], 500);
            }
        }

        try {
            DB::table('mobiles')->insert([
                'brand_id' => $request->brand_id,
                'series_id' => $request->series_id ?: null,
                'storage_id' => $request->storage_id ?: null,
                'name' => $request->name,
                'price' => $request->price,
                'specs' => $request->specs,
                'colors' => $request->colors,
                'image_url' => $imageUrl,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return response()->json(['message' => 'Mobile added']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Database error: Ensure you have executed the SQL to create the "storages" table and add the "storage_id" column to "mobiles". Detail: ' . $e->getMessage()], 500);
        }
    }

    public function deleteMobile($id)
    {
        DB::table('mobiles')->where('id', $id)->delete();
        return response()->json(['message' => 'Mobile deleted']);
    }

    public function downloadMobileList(Request $request)
    {
        $brandId = $request->brand_id;
        $brand = DB::table('brands')->where('id', $brandId)->first();

        if (!$brand) {
            return back()->with('error', 'Brand not found');
        }

        $mobiles = DB::table('mobiles')
            ->where('brand_id', $brandId)
            ->select('name', 'price')
            ->get();

        $filename = $brand->name . "_Mobiles.csv";

        return Response::streamDownload(function () use ($mobiles) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Mobile Name', 'Price']);
            foreach ($mobiles as $mobile) {
                fputcsv($file, [$mobile->name, $mobile->price]);
            }
            fclose($file);
        }, $filename);
    }

    public function printMobileList(Request $request)
    {
        $brandId = $request->brand_id;
        $brand = DB::table('brands')->where('id', $brandId)->first();

        if (!$brand) {
            return back()->with('error', 'Brand not found');
        }

        $mobiles = DB::table('mobiles')
            ->where('brand_id', $brandId)
            ->select('name', 'price')
            ->get();

        return view('admin.mobiles_pdf', compact('brand', 'mobiles'));
    }

    public function updateOrderStatus(Request $request)
    {
        DB::table('orders')->where('id', $request->id)->update(['status' => $request->status, 'updated_at' => now()]);
        return response()->json(['message' => 'Status updated']);
    }

    public function deleteOrder($id)
    {
        DB::table('orders')->where('id', $id)->delete();
        return response()->json(['message' => 'Order deleted']);
    }

    public function updateRefundStatus(Request $request)
    {
        DB::table('refund_requests')->where('id', $request->id)->update(['status' => $request->status, 'updated_at' => now()]);
        return response()->json(['message' => 'Refund status updated']);
    }

    public function deleteRefund($id)
    {
        DB::table('refund_requests')->where('id', $id)->delete();
        return response()->json(['message' => 'Refund request deleted']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate(['current_password' => 'required', 'new_password' => 'required|min:4|confirmed']);
        $admin = DB::table('admins')->first();
        if (!$admin || !Hash::check($request->current_password, $admin->password)) {
            return response()->json(['message' => 'Current password incorrect'], 422);
        }
        DB::table('admins')->where('id', $admin->id)->update(['password' => Hash::make($request->new_password), 'updated_at' => now()]);
        return response()->json(['message' => 'Password updated']);
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function removeScreenshot(Request $request)
    {
        $index = $request->index;
        try {
            $settings = DB::table('app_settings')->where('id', 1)->first();
            $screenshots = json_decode($settings->screenshots ?? '[]', true);

            if (isset($screenshots[$index])) {
                $filePath = public_path($screenshots[$index]);
                if (File::exists($filePath)) File::delete($filePath);
                array_splice($screenshots, $index, 1);
                DB::table('app_settings')->where('id', 1)->update(['screenshots' => json_encode($screenshots), 'updated_at' => now()]);
                return response()->json(['message' => 'Screenshot removed']);
            }
        } catch (\Exception $e) {}
        return response()->json(['message' => 'Error removing screenshot'], 500);
    }
}
