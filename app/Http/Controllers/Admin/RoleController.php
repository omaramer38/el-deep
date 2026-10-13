<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403, 'إدارة أدوار النظام محصورة بمسؤول النظام الرئيسي Super Admin فقط.');
        }

        $roles = Role::withCount(['permissions', 'users'])->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403, 'إدارة أدوار النظام محصورة بمسؤول النظام الرئيسي Super Admin فقط.');
        }

        $permissions = Permission::all()->groupBy(function ($perm) {
            $parts = explode('.', $perm->name);
            return $parts[0] ?? 'general';
        });

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403, 'إدارة أدوار النظام محصورة بمسؤول النظام الرئيسي Super Admin فقط.');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'تم إنشاء الدور والصلاحيات بنجاح.');
    }

    public function edit(Role $role): View
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403, 'إدارة أدوار النظام محصورة بمسؤول النظام الرئيسي Super Admin فقط.');
        }

        $permissions = Permission::all()->groupBy(function ($perm) {
            $parts = explode('.', $perm->name);
            return $parts[0] ?? 'general';
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403, 'إدارة أدوار النظام محصورة بمسؤول النظام الرئيسي Super Admin فقط.');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,'.$role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if ($role->name === 'Super Admin' && $request->name !== 'Super Admin') {
            return back()->with('error', 'لا يمكن تغيير اسم دور Super Admin.');
        }

        $role->name = $request->name;
        $role->save();

        if ($role->name !== 'Super Admin') {
            $role->syncPermissions($request->permissions ?? []);
        }

        return redirect()->route('admin.roles.index')->with('success', 'تم تعديل صلاحيات الدور بنجاح.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403, 'إدارة أدوار النظام محصورة بمسؤول النظام الرئيسي Super Admin فقط.');
        }

        if (in_array($role->name, ['Super Admin', 'Admin'])) {
            return back()->with('error', 'لا يمكن حذف الأدوار الافتراضية للنظام.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف هذا الدور لوجود مستخدمين معينين به حالياً.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'تم حذف الدور بنجاح.');
    }
}
