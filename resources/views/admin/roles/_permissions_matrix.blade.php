@php
    $permissionDescriptions = [
        // Elevators
        'elevators.view' => ['ar' => 'عرض وقراءة المصاعد', 'en' => 'View elevators'],
        'elevators.create' => ['ar' => 'إضافة مصعد جديد', 'en' => 'Create elevator'],
        'elevators.edit' => ['ar' => 'تعديل بيانات المصاعد', 'en' => 'Edit elevators'],
        'elevators.delete' => ['ar' => 'حذف مصعد', 'en' => 'Delete elevator'],
        'elevators.publish' => ['ar' => 'نشر وتفعيل المصاعد', 'en' => 'Publish elevators'],

        // Services
        'services.view' => ['ar' => 'عرض الخدمات الهندسية', 'en' => 'View services'],
        'services.create' => ['ar' => 'إضافة خدمة جديدة', 'en' => 'Create service'],
        'services.edit' => ['ar' => 'تعديل الخدمات', 'en' => 'Edit services'],
        'services.delete' => ['ar' => 'حذف خدمة', 'en' => 'Delete service'],
        'services.publish' => ['ar' => 'نشر وتفعيل الخدمات', 'en' => 'Publish services'],

        // Projects
        'projects.view' => ['ar' => 'عرض المشروعات الهندسية', 'en' => 'View projects'],
        'projects.create' => ['ar' => 'إضافة مشروع جديد', 'en' => 'Create project'],
        'projects.edit' => ['ar' => 'تعديل بيانات المشاريع', 'en' => 'Edit projects'],
        'projects.delete' => ['ar' => 'حذف مشروع', 'en' => 'Delete project'],
        'projects.publish' => ['ar' => 'نشر وتفعيل المشاريع', 'en' => 'Publish projects'],

        // Blog
        'blog.view' => ['ar' => 'عرض المقالات والمدونة', 'en' => 'View articles'],
        'blog.create' => ['ar' => 'كتابة مقال جديد', 'en' => 'Create article'],
        'blog.edit' => ['ar' => 'تعديل المقالات', 'en' => 'Edit articles'],
        'blog.delete' => ['ar' => 'حذف مقال', 'en' => 'Delete article'],
        'blog.publish' => ['ar' => 'نشر وجدولة المقالات', 'en' => 'Publish articles'],

        // Pages
        'pages.view' => ['ar' => 'عرض صفحات الموقع', 'en' => 'View pages'],
        'pages.edit' => ['ar' => 'تعديل محتوى نصوص وأقسام الصفحات', 'en' => 'Edit page content'],
        'pages.publish' => ['ar' => 'نشر التعديلات على الصفحات', 'en' => 'Publish page edits'],

        // Testimonials
        'testimonials.view' => ['ar' => 'عرض آراء وتقييمات العملاء', 'en' => 'View testimonials'],
        'testimonials.manage' => ['ar' => 'إضافة وتعديل وحذف التقييمات', 'en' => 'Manage testimonials'],

        // Partners
        'partners.view' => ['ar' => 'عرض الشركاء والعملاء', 'en' => 'View partners'],
        'partners.manage' => ['ar' => 'إضافة وتعديل وحذف شعارات الشركاء', 'en' => 'Manage partners'],

        // FAQs
        'faqs.view' => ['ar' => 'عرض الأسئلة الشائعة', 'en' => 'View FAQs'],
        'faqs.manage' => ['ar' => 'إضافة وتعديل وحذف الأسئلة الشائعة', 'en' => 'Manage FAQs'],

        // Media
        'media.view' => ['ar' => 'تصفح مكتبة الوسائط والصور', 'en' => 'View media library'],
        'media.manage' => ['ar' => 'رفع وحذف وتنظيم الصور والمجلدات', 'en' => 'Manage media & folders'],

        // Messages
        'messages.view' => ['ar' => 'قراءة رسائل واستفسارات العملاء', 'en' => 'View customer messages'],
        'messages.manage' => ['ar' => 'الرد وتغيير حالة الرسائل وحذفها', 'en' => 'Manage messages'],
        'messages.export' => ['ar' => 'تصدير الرسائل وسجل التواصل', 'en' => 'Export messages'],

        // SEO
        'seo.view' => ['ar' => 'عرض إعدادات محركات البحث SEO', 'en' => 'View SEO settings'],
        'seo.manage' => ['ar' => 'تعديل الميتا تاج والكلمات المفتاحية', 'en' => 'Manage SEO metadata'],

        // Settings
        'settings.view' => ['ar' => 'عرض إعدادات الموقع والنظام', 'en' => 'View site settings'],
        'settings.manage' => ['ar' => 'تعديل بيانات التواصل وإعدادات الموقع', 'en' => 'Manage system settings'],

        // Users
        'users.view' => ['ar' => 'عرض قائمة الموظفين والمدراء', 'en' => 'View admin users'],
        'users.create' => ['ar' => 'إنشاء حساب موظف / أدمن جديد', 'en' => 'Create admin user'],
        'users.edit' => ['ar' => 'تعديل بيانات وصلاحيات الموظفين', 'en' => 'Edit user accounts'],
        'users.delete' => ['ar' => 'حذف أو تعطيل حسابات الموظفين', 'en' => 'Delete user accounts'],

        // Roles
        'roles.view' => ['ar' => 'عرض الأدوار والرتب الإدارية', 'en' => 'View system roles'],
        'roles.manage' => ['ar' => 'إنشاء وتعديل صلاحيات الأدوار والرتب', 'en' => 'Manage roles & permissions'],

        // Activity Log
        'activity.view' => ['ar' => 'عرض ومراقبة سجل العمليات (Audit Log)', 'en' => 'View audit activity log'],
    ];

    $groupTitles = [
        'elevators' => ['ar' => 'المصاعد والمنتجات (Elevators)', 'en' => 'Elevators & Products'],
        'services' => ['ar' => 'الخدمات الهندسية (Services)', 'en' => 'Engineering Services'],
        'projects' => ['ar' => 'المشروعات الهندسية (Projects)', 'en' => 'Engineering Projects'],
        'blog' => ['ar' => 'المدونة والمقالات (Blog)', 'en' => 'Blog & Articles'],
        'pages' => ['ar' => 'محتوى صفحات الموقع (Pages)', 'en' => 'Website Pages'],
        'testimonials' => ['ar' => 'آراء وتقييمات العملاء (Testimonials)', 'en' => 'Client Testimonials'],
        'partners' => ['ar' => 'الشركاء والعملاء (Partners)', 'en' => 'Partners & Clients'],
        'faqs' => ['ar' => 'الأسئلة الشائعة (FAQs)', 'en' => 'Frequently Asked Questions'],
        'media' => ['ar' => 'مكتبة الصور والوسائط (Media)', 'en' => 'Media & Files'],
        'messages' => ['ar' => 'رسائل واستفسارات العملاء (Messages)', 'en' => 'Client Messages'],
        'seo' => ['ar' => 'محركات البحث (SEO)', 'en' => 'Search Engine Optimization'],
        'settings' => ['ar' => 'إعدادات الموقع والنظام (Settings)', 'en' => 'System Settings'],
        'users' => ['ar' => 'المستخدمين والموظفين (Users)', 'en' => 'Administrative Users'],
        'roles' => ['ar' => 'الأدوار والصلاحيات (Roles)', 'en' => 'Roles & Permissions'],
        'activity' => ['ar' => 'سجل النشاطات والعمليات (Activity Log)', 'en' => 'Activity & Audit Log'],
    ];

    $selected = old('permissions', $selectedPermissions ?? []);
    $locale = app()->getLocale() === 'en' ? 'en' : 'ar';
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($permissions as $group => $items)
        @php
            $groupKey = strtolower($group);
            $groupDisplay = $groupTitles[$groupKey][$locale] ?? strtoupper($group);
        @endphp
        <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3" x-data="{ allChecked: false }">
            <div class="flex items-center justify-between border-b border-[#E4DFD8] pb-2">
                <span class="text-xs font-bold text-[#172A35] flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-[#A99776] inline-block"></span>
                    <span>{{ $groupDisplay }}</span>
                </span>
                <button 
                    type="button" 
                    @click="allChecked = !allChecked; $el.closest('div.space-y-3').querySelectorAll('input[type=checkbox]').forEach(el => el.checked = allChecked)" 
                    class="text-[11px] text-[#A99776] hover:text-[#172A35] hover:underline font-semibold cursor-pointer transition-colors"
                >
                    {{ $locale === 'ar' ? 'تحديد / إلغاء الكل' : 'Toggle All' }}
                </button>
            </div>

            <div class="space-y-1">
                @foreach($items as $permission)
                    @php
                        $desc = $permissionDescriptions[$permission->name][$locale] 
                            ?? $permissionDescriptions[$permission->name]['ar'] 
                            ?? null;
                    @endphp
                    <label class="flex items-start gap-2.5 cursor-pointer text-xs p-1.5 hover:bg-white transition-colors border border-transparent hover:border-[#E4DFD8]">
                        <input 
                            type="checkbox" 
                            name="permissions[]" 
                            value="{{ $permission->name }}" 
                            {{ in_array($permission->name, $selected) ? 'checked' : '' }} 
                            class="mt-0.5 rounded-none border-[#C8C0B5] text-[#172A35] focus:ring-0 focus:ring-offset-0"
                        >
                        <div class="flex-1 leading-snug">
                            <span class="font-mono text-[11px] text-[#596269]">{{ $permission->name }}</span>
                            @if($desc)
                                <span class="text-[#172A35] font-semibold text-[11px] ms-1.5">
                                    ({{ $desc }})
                                </span>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
