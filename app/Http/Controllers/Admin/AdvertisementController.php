<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    protected function validateAdvertisement(Request $request, $isUpdate = false)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'link' => 'nullable|url',
            'position' => 'required|in:header,sidebar,footer,between_sections,below_navbar',
            'image' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'nullable|boolean'
        ];

        return $request->validate($rules);
    }

    public function index()
    {
        $advertisements = Advertisement::latest()->paginate(10);
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        return view('admin.advertisements.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Starting advertisement creation with data:', $request->all());
            
            $validated = $this->validateAdvertisement($request);
            \Log::info('Validation passed. Validated data:', $validated);

            if ($request->hasFile('image')) {
                \Log::info('Processing image file');
                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;
                $path = $request->file('image')->storeAs('advertisements', $filename, 'public');
                $validated['image'] = $path;
                \Log::info('Image stored at: ' . $path);
            }

            $validated['active'] = $request->has('active');
            \Log::info('Active status set to: ' . ($validated['active'] ? 'true' : 'false'));

            $advertisement = Advertisement::create($validated);
            \Log::info('Advertisement created with ID: ' . $advertisement->id);

            if (!$advertisement) {
                \Log::error('Failed to create advertisement');
                return back()->with('error', 'فشل في إنشاء الإعلان. حاول مرة أخرى.');
            }

            return redirect()->route('admin.advertisements.index')
                ->with('success', 'تم إضافة الإعلان بنجاح');

        } catch (\Exception $e) {
            \Log::error('Error creating advertisement: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إنشاء الإعلان: ' . $e->getMessage());
        }
    }

    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisements.edit', compact('advertisement'));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        $validated = $this->validateAdvertisement($request, true);

        if ($request->hasFile('image')) {
            if ($advertisement->image) {
                Storage::disk('public')->delete($advertisement->image);
            }
            
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = uniqid() . '.' . $extension;
            $path = $request->file('image')->storeAs('advertisements', $filename, 'public');
            $validated['image'] = $path;
        }

        $validated['active'] = $request->has('active');

        $advertisement->update($validated);

        return redirect()->route('admin.advertisements.index')
            ->with('success', 'تم تحديث الإعلان بنجاح');
    }

    public function destroy(Advertisement $advertisement)
    {
        try {
            // حذف الصورة من التخزين إذا كانت موجودة
            if ($advertisement->image) {
                Storage::disk('public')->delete($advertisement->image);
            }
            
            // حذف الإعلان من قاعدة البيانات
            $advertisement->delete();

            return redirect()->route('admin.advertisements.index')
                ->with('success', 'تم حذف الإعلان والصورة المرتبطة به بنجاح');
        } catch (\Exception $e) {
            \Log::error('Error deleting advertisement: ' . $e->getMessage());
            return redirect()->route('admin.advertisements.index')
                ->with('error', 'حدث خطأ أثناء حذف الإعلان. يرجى المحاولة مرة أخرى.');
        }
    }
}
