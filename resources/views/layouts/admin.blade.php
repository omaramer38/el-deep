<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — EL DEEB System</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @stack('styles')
</head>
<body class="bg-[#F8F9FA] text-[#172A35] min-h-screen flex flex-col font-sans" x-data="{ sidebarOpen: false, userDropdown: false }">
    <div class="flex flex-1 min-h-screen">
        <!-- Sidebar Backdrop for mobile -->
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false" 
            class="fixed inset-0 bg-[#0F1C23]/60 backdrop-blur-xs z-40 lg:hidden"
            style="display: none;"
        ></div>

        <!-- Sidebar Navigation -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : ( '{{ app()->getLocale() === 'ar' ? 'translate-x-full' : '-translate-x-full' }}' + ' lg:translate-x-0')"
            class="fixed inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} z-50 w-72 bg-[#172A35] text-[#F5F1E8] flex flex-col transition-transform duration-300 ease-in-out border-e border-[#233642] select-none"
        >
            <!-- Sidebar Header / Brand -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-[#233642]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/brand/PN 2.png') }}" alt="EL DEEB" class="h-10 w-auto object-contain brightness-110">
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-[#778087] hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto sidebar-scroll px-4 py-6 space-y-6 text-sm">
                <!-- Dashboard -->
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs font-medium uppercase tracking-wider rounded-none {{ request()->routeIs('admin.dashboard') ? 'bg-[#A99776] text-[#0F1C23] font-semibold' : 'text-[#C8C0B5] hover:bg-[#233642] hover:text-white' }} transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>{{ __('admin.dashboard') }}</span>
                    </a>
                </div>

                <!-- Content Management -->
                <div>
                    <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-[#778087]">
                        {{ __('admin.content') }}
                    </div>
                    <div class="space-y-1">
                        @can('projects.view')
                        <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.projects.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span>{{ __('admin.projects') }}</span>
                        </a>
                        @endcan

                        @can('elevators.view')
                        <a href="{{ route('admin.elevators.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.elevators.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7v10M16 7v10M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z"></path></svg>
                            <span>{{ __('admin.elevators') }}</span>
                        </a>
                        @endcan

                        @can('services.view')
                        <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.services.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            <span>{{ __('admin.services') }}</span>
                        </a>
                        @endcan

                        @can('blog.view')
                        <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.blog.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            <span>{{ __('admin.blog') }}</span>
                        </a>
                        @endcan

                        @can('media.view')
                        <a href="{{ route('admin.media.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.media.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>{{ __('admin.media_library') }}</span>
                        </a>
                        @endcan

                        <a href="{{ route('admin.catalogues.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.catalogues.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>{{ app()->getLocale() === 'ar' ? 'الكتالوجات (PDF)' : 'Catalogues (PDF)' }}</span>
                        </a>
                    </div>
                </div>

                <!-- Website Pages & Page Builder -->
                <div>
                    <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-[#778087]">
                        {{ __('admin.website_content') }}
                    </div>
                    <div class="space-y-1">
                        @can('pages.view')
                        <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.pages.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>{{ __('admin.website_content') }}</span>
                        </a>
                        @endcan

                        <a href="{{ route('admin.testimonials.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.testimonials.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            <span>{{ __('admin.testimonials') }}</span>
                        </a>

                        <a href="{{ route('admin.partners.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.partners.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span>{{ __('admin.partners') }}</span>
                        </a>

                        <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.faqs.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ __('admin.faqs') }}</span>
                        </a>
                    </div>
                </div>

                <!-- Communication -->
                <div>
                    <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-[#778087]">
                        {{ __('admin.communication') }}
                    </div>
                    <div class="space-y-1">
                        @can('messages.view')
                        <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.messages.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>{{ __('admin.messages') }}</span>
                            </div>
                            @php
                                $unreadCount = \App\Models\ContactMessage::where('status', 'new')->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="bg-[#A99776] text-[#0F1C23] font-bold text-[10px] px-1.5 py-0.5 rounded-full">{{ $unreadCount }}</span>
                            @endif
                        </a>
                        @endcan
                    </div>
                </div>

                <!-- System & Security -->
                <div>
                    <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-[#778087]">
                        {{ __('admin.system') }}
                    </div>
                    <div class="space-y-1">
                        @can('users.view')
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.users.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>{{ __('admin.users') }}</span>
                        </a>
                        @endcan

                        @can('roles.view')
                        <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.roles.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>{{ __('admin.roles') }}</span>
                        </a>
                        @endcan

                        @can('activity.view')
                        <a href="{{ route('admin.activity.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.activity.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ __('admin.activity_log') }}</span>
                        </a>
                        @endcan

                        @can('settings.view')
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 text-xs rounded-none {{ request()->routeIs('admin.settings.*') ? 'bg-[#233642] text-[#A99776] border-s-2 border-[#A99776]' : 'text-[#C8C0B5] hover:bg-[#1E2E38] hover:text-white' }} transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            <span>{{ __('admin.settings') }}</span>
                        </a>
                        @endcan
                    </div>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-[#233642] text-[11px] text-[#778087] flex items-center justify-between">
                <span>v1.0 &bull; Secure</span>
                <a href="{{ url('/') }}" target="_blank" class="text-[#A99776] hover:underline flex items-center gap-1">
                    <span>View Site</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col min-w-0 {{ app()->getLocale() === 'ar' ? 'lg:mr-72' : 'lg:ml-72' }}">
            <!-- Top Navbar -->
            <header class="h-20 bg-white border-b border-[#E4DFD8] flex items-center justify-between px-6 sticky top-0 z-30 shadow-xs">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-[#172A35] p-2 hover:bg-[#F5F1E8]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="text-sm font-semibold tracking-wide text-[#172A35]">
                        @yield('header_title', 'Administrative Overview')
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Language Switcher -->
                    <div class="inline-flex items-center border border-[#C8C0B5] bg-[#F8F9FA] p-0.5 text-xs">
                        <a 
                            href="{{ route('admin.switch-locale', 'ar') }}" 
                            class="px-2.5 py-1 text-xs font-semibold transition-colors {{ app()->getLocale() === 'ar' ? 'bg-[#172A35] text-white shadow-xs' : 'text-[#596269] hover:text-[#172A35]' }}"
                        >
                            العربية
                        </a>
                        <a 
                            href="{{ route('admin.switch-locale', 'en') }}" 
                            class="px-2.5 py-1 text-xs font-semibold transition-colors {{ app()->getLocale() === 'en' ? 'bg-[#172A35] text-white shadow-xs' : 'text-[#596269] hover:text-[#172A35]' }}"
                        >
                            English
                        </a>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2.5 p-1.5 hover:bg-[#F5F1E8] transition-colors text-xs font-medium cursor-pointer">
                            <div class="w-8 h-8 bg-[#172A35] text-[#F5F1E8] flex items-center justify-center font-bold text-xs uppercase">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="hidden md:inline text-[#172A35]">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <svg class="w-3.5 h-3.5 text-[#778087]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div 
                            x-show="open" 
                            @click.away="open = false" 
                            x-transition
                            class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white border border-[#E4DFD8] shadow-xl py-2 z-50 text-xs"
                            style="display: none;"
                        >
                            <div class="px-4 py-2 border-b border-[#F0ECE1] text-[11px] text-[#778087]">
                                <div class="font-medium text-[#172A35]">{{ auth()->user()->name }}</div>
                                <div class="truncate">{{ auth()->user()->email }}</div>
                            </div>

                            <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-[#172A35] hover:bg-[#F5F1E8] transition-colors">
                                {{ __('admin.profile') }}
                            </a>
                            <a href="{{ route('admin.two-factor.setup') }}" class="block px-4 py-2 text-[#172A35] hover:bg-[#F5F1E8] transition-colors">
                                {{ __('admin.two_factor') }}
                            </a>

                            <div class="border-t border-[#F0ECE1] mt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-start px-4 py-2 text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                        {{ __('admin.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Notifications / Flash messages -->
            @if(session('success'))
                <div class="m-6 mb-0 p-4 bg-[#EAF5EC] border border-[#BDE0C3] text-[#1E4620] text-xs flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-[#1E4620] font-bold">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="m-6 mb-0 p-4 bg-[#FDEAEA] border border-[#F5C2C2] text-[#6E1A1A] text-xs flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-[#6E1A1A] font-bold">&times;</button>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1 p-6 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
