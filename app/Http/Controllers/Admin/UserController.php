<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('roles')->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'is_active' => 'boolean',
        ]);

        // Privilege escalation defense: only Super Admin can grant Super Admin role
        if (in_array('Super Admin', $request->roles) && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'لا تملك الصلاحية لمنح دور مسؤول النظام الرئيسي (Super Admin).');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => now(),
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء حساب المستخدم بنجاح.');
    }

    public function edit(User $user): View
    {
        // Non-Super Admin cannot edit a Super Admin account
        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'لا يمكن تعديل بيانات مسؤول النظام الرئيسي إلا بواسطة Super Admin.');
        }

        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        // Non-Super Admin cannot edit a Super Admin account
        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'لا يمكن تعديل بيانات مسؤول النظام الرئيسي إلا بواسطة Super Admin.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'is_active' => 'boolean',
        ]);

        // Privilege escalation defense: only Super Admin can grant Super Admin role
        if (in_array('Super Admin', $request->roles) && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'لا تملك الصلاحية لمنح دور مسؤول النظام الرئيسي (Super Admin).');
        }

        // Lockout defense: Cannot remove Super Admin from last active Super Admin
        if ($user->isSuperAdmin() && ! in_array('Super Admin', $request->roles)) {
            if (User::role('Super Admin')->count() <= 1) {
                return back()->with('error', 'لا يمكن تجريد آخر مسؤول Super Admin من دوره القيادي في النظام.');
            }
        }

        // Lockout defense: Cannot deactivate the last Super Admin
        if ($user->isSuperAdmin() && ! $request->boolean('is_active')) {
            if (User::role('Super Admin')->where('is_active', true)->count() <= 1) {
                return back()->with('error', 'لا يمكن تعطيل الحساب النشط الوحيد لمسؤول Super Admin.');
            }
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'لا يمكنك حذف حسابك الشخصي المسجل به حالياً.');
        }

        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'لا تملك الصلاحية لحذف حساب Super Admin.');
        }

        if ($user->isSuperAdmin() && User::role('Super Admin')->count() <= 1) {
            return back()->with('error', 'لا يمكن حذف المسؤول الأخير ذو صلاحيات Super Admin.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف حساب المستخدم بنجاح.');
    }
}
