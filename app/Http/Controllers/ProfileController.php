<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index(Request $request): View
    {
        return view('admin.profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's basic information.
     */
    public function updateInfo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
        ]);

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('admin.profile.index')->with('success', 'تم تحديث المعلومات الشخصية بنجاح');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return Redirect::route('admin.profile.index')->with('success', 'تم تحديث كلمة المرور بنجاح');
    }

    /**
     * Update the user's preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'theme' => ['required', 'string', 'in:light,dark,system'],
            'language' => ['required', 'string', 'in:ar,en'],
            'notifications_enabled' => ['boolean'],
        ]);

        $request->user()->update($validated);

        return Redirect::route('admin.profile.index')->with('success', 'تم تحديث التفضيلات بنجاح');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'], // Max 2MB
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($request->user()->profile_picture) {
                Storage::delete($request->user()->profile_picture);
            }
            
            // Store the new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            
            // Update user's profile picture
            $request->user()->update([
                'profile_picture' => $path
            ]);

            return Redirect::route('admin.profile.index')
                ->with('success', 'تم تحديث الصورة الشخصية بنجاح');
        }

        return Redirect::route('admin.profile.index')
            ->with('error', 'حدث خطأ أثناء تحديث الصورة الشخصية');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
        ]);

        auth()->user()->update($request->only('name', 'email'));

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
}
