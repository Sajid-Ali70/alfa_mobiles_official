<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

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

        $mobiles = DB::table('mobiles')
            ->join('brands', 'mobiles.brand_id', '=', 'brands.id')
            ->leftJoin('series', 'mobiles.series_id', '=', 'series.id')
            ->select('mobiles.*', 'brands.name as brand_name', 'series.name as series_name')
            ->orderBy('mobiles.id', 'desc')
            ->get();

        $orders = DB::table('orders')->orderBy('id', 'desc')->get();

        return view('admin.dashboard', compact('settings', 'brands', 'series', 'mobiles', 'orders'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->only([
            'app_name', 'contact_number', 'contact_email',
            'developer', 'category', 'tags', 'rating_score',
            'reviews_count', 'downloads_count', 'content_rating',
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

    public function addMobile(Request $request)
    {
        $request->validate(['name' => 'required', 'brand_id' => 'required', 'price' => 'required']);
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'mobile_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/mobiles'), $fileName);
            $imageUrl = '/uploads/mobiles/' . $fileName;
        }
        DB::table('mobiles')->insert([
            'brand_id' => $request->brand_id,
            'series_id' => $request->series_id,
            'name' => $request->name,
            'price' => $request->price,
            'specs' => $request->specs,
            'image_url' => $imageUrl,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return response()->json(['message' => 'Mobile added']);
    }

    public function deleteMobile($id)
    {
        DB::table('mobiles')->where('id', $id)->delete();
        return response()->json(['message' => 'Mobile deleted']);
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
