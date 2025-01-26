<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class SettingsController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            $settings = Setting::firstOrNew(['id' => 1]);
            
            // تحديث البيانات الأساسية
            $settings->site_name = $request->site_name;
            $settings->site_description = $request->site_description;
            $settings->facebook_url = $request->facebook_url;
            $settings->twitter_url = $request->twitter_url;
            $settings->instagram_url = $request->instagram_url;
            $settings->youtube_url = $request->youtube_url;
            
            // تحديث أبعاد الشعار
            $settings->logo_width = intval($request->logo_width);
            $settings->logo_height = intval($request->logo_height);
            
            // معالجة الشعار
            if ($request->hasFile('site_logo')) {
                $file = $request->file('site_logo');
                if ($file->isValid()) {
                    // حذف الشعار القديم إذا كان موجوداً
                    if ($settings->site_logo) {
                        Storage::disk('public')->delete($settings->site_logo);
                    }
                    
                    // حفظ الشعار الجديد
                    $settings->site_logo = $request->file('site_logo')->store('settings', 'public');
                }
            }

            // معالجة الأيقونة المفضلة
            if ($request->hasFile('site_favicon')) {
                $file = $request->file('site_favicon');
                if ($file->isValid()) {
                    // حذف الأيقونة القديمة إذا كانت موجودة
                    if ($settings->site_favicon) {
                        $oldPath = public_path($settings->site_favicon);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                    
                    // حفظ الأيقونة الجديدة في مجلد public
                    $filename = 'favicon.ico';
                    $file->move(public_path(), $filename);
                    $settings->site_favicon = $filename;
                }
            }

            $settings->save();

            return redirect()->route('admin.settings.index')
                           ->with('success', 'تم تحديث الإعدادات بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                           ->with('error', 'حدث خطأ أثناء تحديث الإعدادات: ' . $e->getMessage());
        }
    }
}