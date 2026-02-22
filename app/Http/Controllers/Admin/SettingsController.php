<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{

    public function index()
    {
        $settings = Setting::first();

        return view('admin.settings.index', compact('settings'));
    }


    public function update(Request $request)
    {

        $settings = Setting::first();

        if (!$settings) {

            $settings = new Setting();
        }


        $settings->site_name = $request->site_name;
        $settings->email = $request->email;
        $settings->phone = $request->phone;


        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/settings', $filename);

            $settings->logo = 'settings/' . $filename;
        }


        $settings->save();


        return back()->with('success', 'تم حفظ الإعدادات بنجاح');

    }

}
