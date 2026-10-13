<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user()->load('roles');

        $sessionInfo = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'last_login_at' => $user->last_login_at,
            'last_login_ip' => $user->last_login_ip,
        ];

        return view('admin.profile', compact('user', 'sessionInfo'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['new_password'])) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return back()->with('success', __('admin.saved'));
    }

    public function twoFactorSetup(Request $request): View
    {
        $user = $request->user();

        return view('admin.two-factor-setup', compact('user'));
    }

    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        Auth::logoutOtherDevices($request->password);

        return back()->with('success', app()->getLocale() === 'ar' 
            ? 'تم تسجيل الخروج من كافة الأجهزة والجلسات الأخرى بنجاح.' 
            : 'Logged out of all other device sessions successfully.');
    }
}
