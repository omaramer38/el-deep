@extends('layouts.admin')

@section('title', __('admin.profile'))
@section('header_title', __('admin.profile'))

@section('content')
<div class="max-w-4xl space-y-6" x-data="{ showPass: false, logoutModal: false }">

    <!-- Executive Profile Header Card -->
    <div class="bg-white border border-[#E4DFD8] shadow-xs p-6 relative">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <!-- Avatar Monogram -->
                <div class="w-16 h-16 bg-[#172A35] border-2 border-[#A99776] text-[#F5F1E8] flex items-center justify-center font-bold text-2xl font-serif shrink-0 uppercase relative">
                    {{ substr($user->name, 0, 1) }}
                    @if($user->is_active)
                        <span class="absolute bottom-0 end-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full" title="Active"></span>
                    @endif
                </div>

                <div class="space-y-1">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h1 class="text-xl font-serif font-bold text-[#172A35] leading-tight">
                            {{ $user->name }}
                        </h1>

                        <!-- Role Badge -->
                        @if($user->isSuperAdmin())
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-[#FAF8F4] border border-[#A99776] text-[#8A7755] text-[11px] font-bold uppercase tracking-wider shadow-xs">
                                <svg class="w-3.5 h-3.5 text-[#A99776]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 011.392 1.157l-1.12 4.478 3.013 3.014a1 1 0 01-.707 1.707H.869a1 1 0 01-.707-1.707l3.013-3.014-1.12-4.478A1 1 0 013.447 5.1l1.6.8L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                <span>Super Admin</span>
                            </span>
                        @else
                            @foreach($user->roles as $role)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-[#FAF8F4] border border-[#C8C0B5] text-[#172A35] text-[11px] font-bold uppercase tracking-wider">
                                    <span>{{ $role->name }}</span>
                                </span>
                            @endforeach
                        @endif

                        <!-- Status Pill -->
                        <span class="px-2 py-0.5 text-[10px] font-semibold bg-[#EAF5EC] text-[#1E4620] uppercase tracking-wider">
                            {{ app()->getLocale() === 'ar' ? 'حساب نشط' : 'Active Account' }}
                        </span>
                    </div>
                    <div class="text-xs text-[#778087] font-mono flex items-center gap-3 flex-wrap">
                        <span>{{ $user->email }}</span>
                        <span>&bull;</span>
                        <span>{{ app()->getLocale() === 'ar' ? 'عضو منذ:' : 'Member since:' }} {{ $user->created_at->format('Y-m-d') }}</span>
                    </div>
                </div>
            </div>

            <!-- Header Quick 2FA status indicator -->
            <div class="flex items-center gap-2">
                @if($user->two_factor_confirmed_at)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#EAF5EC] border border-[#BDE0C3] text-[#1E4620] text-xs font-semibold">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>{{ app()->getLocale() === 'ar' ? '2FA مفعّل' : '2FA Active' }}</span>
                    </span>
                @else
                    <a href="{{ route('admin.two-factor.setup') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-300 text-amber-900 text-xs font-semibold hover:bg-amber-100 transition-colors">
                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'تأمين الحساب بـ 2FA' : 'Enable 2FA' }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Profile Form (Credentials & Password) -->
    <div class="bg-white p-6 sm:p-8 border border-[#E4DFD8] shadow-xs">
        <div class="flex items-center justify-between border-b border-[#F0ECE1] pb-4 mb-6">
            <div>
                <h2 class="text-base font-serif font-bold text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'البيانات الشخصية وكلمة المرور' : 'Personal Credentials & Password' }}
                </h2>
                <p class="text-xs text-[#596269] mt-0.5">
                    {{ app()->getLocale() === 'ar' ? 'تحديث الاسم والبريد الإلكتروني وتعيين كلمة مرور جديدة.' : 'Update your administrator name, email, and password credentials.' }}
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Personal Info Inputs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] uppercase tracking-wider mb-1.5">
                        {{ app()->getLocale() === 'ar' ? 'الاسم الكامل *' : 'Full Name *' }}
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name', $user->name) }}" 
                        required 
                        class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-2.5 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]"
                    >
                    @error('name')
                        <span class="text-[11px] text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] uppercase tracking-wider mb-1.5">
                        {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني *' : 'Email Address *' }}
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}" 
                        required 
                        class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-2.5 text-xs text-[#172A35] font-mono focus:outline-none focus:border-[#A99776]"
                    >
                    @error('email')
                        <span class="text-[11px] text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="pt-6 border-t border-[#E4DFD8] space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35]">
                            {{ app()->getLocale() === 'ar' ? 'تغيير كلمة المرور (اختياري)' : 'Change Password (Optional)' }}
                        </h3>
                        <p class="text-[11px] text-[#778087]">
                            {{ app()->getLocale() === 'ar' ? 'اترك الحقول فارغة إذا كنت لا ترغب في تغيير كلمة المرور الحالية.' : 'Leave blank if you do not want to change your current password.' }}
                        </p>
                    </div>

                    <button 
                        type="button" 
                        @click="showPass = !showPass" 
                        class="text-[11px] font-semibold text-[#A99776] hover:underline cursor-pointer"
                    >
                        <span x-show="!showPass">{{ app()->getLocale() === 'ar' ? 'إظهار كلمات المرور' : 'Show passwords' }}</span>
                        <span x-show="showPass" style="display: none;">{{ app()->getLocale() === 'ar' ? 'إخفاء كلمات المرور' : 'Hide passwords' }}</span>
                    </button>
                </div>

                <div class="space-y-4 max-w-xl">
                    <div>
                        <label class="block text-xs font-semibold text-[#596269] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'كلمة المرور الحالية' : 'Current Password' }}
                        </label>
                        <input 
                            :type="showPass ? 'text' : 'password'" 
                            name="current_password" 
                            autocomplete="current-password"
                            class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-2.5 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]"
                            placeholder="••••••••••••"
                        >
                        @error('current_password')
                            <span class="text-[11px] text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[#596269] mb-1">
                                {{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}
                            </label>
                            <input 
                                :type="showPass ? 'text' : 'password'" 
                                name="new_password" 
                                autocomplete="new-password"
                                class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-2.5 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]"
                                placeholder="Min 8 characters"
                            >
                            @error('new_password')
                                <span class="text-[11px] text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-[#596269] mb-1">
                                {{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور الجديدة' : 'Confirm New Password' }}
                            </label>
                            <input 
                                :type="showPass ? 'text' : 'password'" 
                                name="new_password_confirmation" 
                                autocomplete="new-password"
                                class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-2.5 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]"
                                placeholder="Repeat new password"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-[#E4DFD8] flex items-center justify-end">
                <button type="submit" class="bg-[#172A35] hover:bg-[#A99776] text-[#F5F1E8] px-6 py-2.5 text-xs uppercase tracking-widest font-bold transition-colors cursor-pointer shadow-xs">
                    {{ __('admin.save') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Two-Factor Authentication Integration Card -->
    <div class="bg-white p-6 sm:p-8 border border-[#E4DFD8] shadow-xs space-y-4">
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 bg-[#FAF8F4] border border-[#C8C0B5] flex items-center justify-center text-[#172A35] shrink-0">
                    <svg class="w-5 h-5 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35]">
                        {{ app()->getLocale() === 'ar' ? 'المصادقة الثنائية (TOTP 2FA)' : 'Two-Factor Authentication' }}
                    </h3>
                    <p class="text-xs text-[#596269] leading-relaxed max-w-xl">
                        {{ app()->getLocale() === 'ar' 
                            ? 'إلزام إدخال كود المصادقة المؤقت من تطبيق Google Authenticator عند تسجيل الدخول لحماية لوحة التحكم وصلاحيات الحساب.' 
                            : 'Require temporary verification code from your authenticator app upon login to secure system privileges.' }}
                    </p>
                </div>
            </div>

            <a 
                href="{{ route('admin.two-factor.setup') }}" 
                class="px-4 py-2 bg-[#FAF8F4] border border-[#C8C0B5] hover:border-[#172A35] hover:bg-[#172A35] hover:text-white text-[#172A35] transition-colors text-xs font-bold uppercase tracking-wider cursor-pointer"
            >
                {{ $user->two_factor_confirmed_at 
                    ? (app()->getLocale() === 'ar' ? 'إدارة إعدادات 2FA ورموز الاسترداد' : 'Manage 2FA & Recovery Codes') 
                    : (app()->getLocale() === 'ar' ? 'تفعيل 2FA الآن' : 'Enable 2FA Now') }}
            </a>
        </div>
    </div>

    <!-- Active Sessions & Security Telemetry -->
    <div class="bg-white p-6 sm:p-8 border border-[#E4DFD8] shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-[#F0ECE1] pb-3">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] flex items-center gap-2">
                <svg class="w-4 h-4 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'سجل الأمان والجلسة النشطة' : 'Active Session & Security Log' }}</span>
            </h3>

            <button 
                type="button" 
                @click="logoutModal = true" 
                class="text-[11px] text-red-600 hover:text-red-800 font-semibold underline cursor-pointer"
            >
                {{ app()->getLocale() === 'ar' ? 'تسجيل الخروج من كافة الأجهزة الأخرى' : 'Log out other browser sessions' }}
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
            <div class="p-3.5 bg-[#FAF8F4] border border-[#E4DFD8]">
                <div class="text-[10px] uppercase tracking-wider text-[#778087] font-semibold">{{ app()->getLocale() === 'ar' ? 'عنوان IP الحالي' : 'Current IP' }}</div>
                <div class="font-mono font-bold text-[#172A35] mt-1">{{ $sessionInfo['ip'] ?? '127.0.0.1' }}</div>
            </div>

            <div class="p-3.5 bg-[#FAF8F4] border border-[#E4DFD8]">
                <div class="text-[10px] uppercase tracking-wider text-[#778087] font-semibold">{{ app()->getLocale() === 'ar' ? 'آخر تسجيل دخول' : 'Last Login' }}</div>
                <div class="font-mono font-bold text-[#172A35] mt-1">{{ $sessionInfo['last_login_at'] ? $sessionInfo['last_login_at']->diffForHumans() : '—' }}</div>
            </div>

            <div class="p-3.5 bg-[#FAF8F4] border border-[#E4DFD8]">
                <div class="text-[10px] uppercase tracking-wider text-[#778087] font-semibold">{{ app()->getLocale() === 'ar' ? 'عنوان IP لآخر دخول' : 'Last Login IP' }}</div>
                <div class="font-mono font-bold text-[#172A35] mt-1">{{ $sessionInfo['last_login_ip'] ?? '—' }}</div>
            </div>
        </div>
    </div>

    <!-- Logout Other Devices Modal -->
    <div 
        x-show="logoutModal" 
        style="display: none;" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-[#0F1C23]/60 backdrop-blur-xs p-4"
    >
        <div 
            @click.away="logoutModal = false" 
            class="bg-white border border-[#E4DFD8] max-w-md w-full p-6 shadow-2xl space-y-4"
        >
            <h3 class="text-sm font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'تسجيل الخروج من باقي الأجهزة' : 'Log Out Other Browser Sessions' }}
            </h3>
            <p class="text-xs text-[#596269] leading-relaxed">
                {{ app()->getLocale() === 'ar' 
                    ? 'يرجى إدخال كلمة المرور لتأكيد رغبتك في إبطال وتسجيل الخروج من أي جلسات مفتوحة أخرى على أجهزة أو متصفحات أخرى.' 
                    : 'Please enter your password to confirm logging out of your account on all other devices.' }}
            </p>

            <form method="POST" action="{{ route('admin.profile.logout-other-devices') }}" class="space-y-4">
                @csrf
                <div>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        placeholder="••••••••••••" 
                        class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-2 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]"
                    >
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button 
                        type="button" 
                        @click="logoutModal = false" 
                        class="px-3.5 py-2 text-xs font-semibold border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] cursor-pointer"
                    >
                        {{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-xs font-bold bg-red-700 hover:bg-red-800 text-white cursor-pointer"
                    >
                        {{ app()->getLocale() === 'ar' ? 'تأكيد الخروج' : 'Log Out Others' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
