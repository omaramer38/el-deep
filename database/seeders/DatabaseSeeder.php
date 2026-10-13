<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Elevator;
use App\Models\ElevatorCategory;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        // 1. Settings
        Setting::set('site_name', ['en' => 'EL DEEB ELEVATOR & BUILDING SYSTEM', 'ar' => 'الديب للمصاعد وأنظمة المباني']);
        Setting::set('site_tagline', ['en' => 'Moving People. Building Confidence.', 'ar' => 'تحريك الأفراد. بناء الثقة.']);
        Setting::set('contact_phone', '[PLACEHOLDER] +20 2 0000 0000');
        Setting::set('contact_email', '[PLACEHOLDER] info@eldeeb-elevators.com');
        Setting::set('contact_whatsapp', '[PLACEHOLDER] +20 100 000 0000');
        Setting::set('contact_address', ['en' => '[PLACEHOLDER] Financial & Business District, New Cairo, Egypt', 'ar' => '[PLACEHOLDER] حي المال والأعمال، القاهرة الجديدة، مصر']);
        Setting::set('contact_hours', ['en' => 'Sun - Thu: 9:00 AM - 6:00 PM', 'ar' => 'الأحد - الخميس: 9:00 ص - 6:00 م']);

        // 2. Pages
        $homePage = Page::updateOrCreate(
            ['key' => 'home'],
            ['title' => ['en' => 'Home', 'ar' => 'الرئيسية'], 'status' => 'published', 'published_at' => now()]
        );

        $aboutPage = Page::updateOrCreate(
            ['key' => 'about'],
            ['title' => ['en' => 'About Us', 'ar' => 'عن الشركة'], 'status' => 'published', 'published_at' => now()]
        );

        // 3. Elevator Categories
        $categoriesData = [
            ['en' => 'Passenger Elevators', 'ar' => 'مصاعد الركاب', 'slug_en' => 'passenger-elevators', 'slug_ar' => 'passenger-elevators'],
            ['en' => 'Panoramic Observation', 'ar' => 'المصاعد البانورامية', 'slug_en' => 'panoramic-elevators', 'slug_ar' => 'panoramic-elevators'],
            ['en' => 'Hospital & Medical', 'ar' => 'مصاعد المستشفيات والخدمة الطبية', 'slug_en' => 'hospital-elevators', 'slug_ar' => 'hospital-elevators'],
            ['en' => 'Freight & Heavy Cargo', 'ar' => 'مصاعد البضائع والأحمال الثقيلة', 'slug_en' => 'freight-elevators', 'slug_ar' => 'freight-elevators'],
            ['en' => 'Home & Luxury Villa', 'ar' => 'مصاعد الفلل والمنازل الفاخرة', 'slug_en' => 'home-elevators', 'slug_ar' => 'home-elevators'],
            ['en' => 'Specialized Systems', 'ar' => 'أنظمة المباني الخاصة', 'slug_en' => 'specialized-systems', 'slug_ar' => 'specialized-systems'],
        ];

        $seededElevatorCategories = [];
        foreach ($categoriesData as $idx => $cat) {
            $seededElevatorCategories[] = ElevatorCategory::updateOrCreate(
                ['slug->en' => $cat['slug_en']],
                [
                    'name' => ['en' => $cat['en'], 'ar' => $cat['ar']],
                    'slug' => ['en' => $cat['slug_en'], 'ar' => $cat['slug_ar']],
                    'sort_order' => $idx + 1,
                    'status' => 'published',
                ]
            );
        }

        // 4. Sample Elevators (6 items)
        $sampleElevators = [
            [
                'category_id' => $seededElevatorCategories[0]->id,
                'name' => ['en' => 'AeroLine Commercial Passenger Elevator', 'ar' => 'مصعد الركاب التجاري AeroLine'],
                'slug' => ['en' => 'aeroline-commercial-passenger-elevator', 'ar' => 'aeroline-passenger-elevator'],
                'short_description' => [
                    'en' => 'High-capacity, smooth gearless traction elevator engineered for prestigious commercial towers and corporate headquarters.',
                    'ar' => 'مصعد جر بدون تروس فائق الكفاءة والهدوء، مصمم خصيصاً للأبراج التجارية ومقرات الشركات المرموقة.',
                ],
                'description' => [
                    'en' => 'The AeroLine series combines Swiss-engineered traction geometry with precision digital dispatching.',
                    'ar' => 'تجمع سلسلة AeroLine بين دقة المحركات اللاترسية وتكنولوجيا التحكم الرقمي الذكي لتوفير تجربة تنقل هادئة وسلسة.',
                ],
                'specifications' => [
                    'en' => [
                        'Rated Capacity' => '630 kg - 2,500 kg (8 to 33 persons)',
                        'Rated Speed' => '1.0 m/s - 4.0 m/s',
                        'Max Travel Height' => '150 meters',
                        'Cabin Finish' => 'Satin Stainless Steel & Smoked Bronze Accents',
                        'Control System' => 'VVVF Microprocessor Dispatching',
                    ],
                    'ar' => [
                        'الحمولة الاسمية' => '630 كجم - 2500 كجم (8 إلى 33 راكباً)',
                        'السرعة الاسمية' => '1.0 م/ث - 4.0 م/ث',
                        'أقصى ارتفاع مسار' => '150 متراً',
                        'تشطيب الكابينة' => 'ستانلس ستيل ساتان مع لمسات برونزية مدخنة',
                        'نظام التحكم' => 'تحكم رقمي دقيق بنظام VVVF الموفر للطاقة',
                    ],
                ],
                'is_featured' => true,
            ],
            [
                'category_id' => $seededElevatorCategories[1]->id,
                'name' => ['en' => 'Spectra Panoramic Glass Elevator', 'ar' => 'مصعد Spectra البانورامي الزجاجي'],
                'slug' => ['en' => 'spectra-panoramic-glass-elevator', 'ar' => 'spectra-panoramic-glass-elevator'],
                'short_description' => [
                    'en' => 'Spectacular architectural glass elevator with 360-degree vistas, engineered for luxury shopping centers and modern atriums.',
                    'ar' => 'مصعد زجاجي معماري استثنائي يوفر رؤية بانورامية ساحرة للمراكز التجارية والفنادق الفاخرة.',
                ],
                'description' => [
                    'en' => 'Designed as an architectural centerpiece, Spectra delivers exceptional passenger comfort with laminated safety curved glass.',
                    'ar' => 'صُمم مصعد Spectra ليكون تحفة معمارية متألقة تجمع بين روعة الرؤية وأعلى معايير الأمان الميكانيكي.',
                ],
                'specifications' => [
                    'en' => [
                        'Rated Capacity' => '1,000 kg - 1,600 kg',
                        'Rated Speed' => '1.0 m/s - 2.5 m/s',
                        'Glass Type' => 'Multi-layer laminated acoustic safety glass',
                        'Illumination' => 'Integrated indirect warm LED halo',
                    ],
                    'ar' => [
                        'الحمولة' => '1000 كجم - 1600 كجم',
                        'السرعة' => '1.0 م/ث - 2.5 م/ث',
                        'نوع الزجاج' => 'زجاج أمان مصفح متعدد الطبقات عازل للصوت',
                        'الإضاءة' => 'إضاءة دافئة غير مباشرة مدمجة',
                    ],
                ],
                'is_featured' => true,
            ],
            [
                'category_id' => $seededElevatorCategories[2]->id,
                'name' => ['en' => 'MediShift Hospital Bed & Stretcher Elevator', 'ar' => 'مصعد المستشفيات والأسرة الطبية MediShift'],
                'slug' => ['en' => 'medishift-hospital-elevator', 'ar' => 'medishift-hospital-elevator'],
                'short_description' => [
                    'en' => 'Precise leveling, extra-deep cabin dimensions, and antimicrobial hygiene surfaces tailored for healthcare institutions.',
                    'ar' => 'توقف شديد الدقة متطابق مع مستوى الأرضيات، وأبعاد مخصصة لنقل الأسرة الطبية مع أسطح مضادة للميكروبات.',
                ],
                'description' => [
                    'en' => 'MediShift is purpose-built for hospitals where smooth acceleration, zero vibration, and code-blue emergency priority are critical.',
                    'ar' => 'مصمم خصيصاً للمراكز الطبية والمستشفيات مع نظام أولوية الطوارئ الطبية والتسارع السلس الخالي من الاهتزاز.',
                ],
                'specifications' => [
                    'en' => ['Capacity' => '1,600 kg - 2,500 kg', 'Door Clearance' => '1200mm - 1500mm Telescopic'],
                    'ar' => ['الحمولة' => '1600 كجم - 2500 كجم', 'عرض فتح الباب' => '1200 مم - 1500 مم تلسكوبي'],
                ],
                'is_featured' => true,
            ],
            [
                'category_id' => $seededElevatorCategories[4]->id,
                'name' => ['en' => 'Maison Luxury Villa Home Lift', 'ar' => 'مصعد الفلل السكنية الفاخرة Maison'],
                'slug' => ['en' => 'maison-luxury-home-lift', 'ar' => 'maison-luxury-home-lift'],
                'short_description' => [
                    'en' => 'Compact pitless or ultra-shallow pit home elevator with whisper-quiet operation and bespoke interior craftsmanship.',
                    'ar' => 'مصعد منزلي فائق الهدوء بدون حفرة عميقة، مصمم بتشطيبات راقية تناسب الفلل والقصور الخاصة.',
                ],
                'description' => [
                    'en' => 'Engineered for private residences without requiring large machine rooms or intrusive structural modifications.',
                    'ar' => 'حل هندسي متكامل للمنازل الخاصة لا يتطلب غرفة ماكينات علوية ويستهلك طاقة منخفضة مثل الأجهزة المنزلية.',
                ],
                'specifications' => [
                    'en' => ['Power' => 'Single-phase 220V or 3-phase', 'Noise Level' => '< 45 dB'],
                    'ar' => ['التيار الكهربائي' => '220 فولت أحادي الوجه أو ثلاثي الوجه', 'مستوى الصوت' => 'أقل من 45 ديسيبل'],
                ],
                'is_featured' => true,
            ],
        ];

        foreach ($sampleElevators as $idx => $el) {
            Elevator::updateOrCreate(
                ['slug->en' => $el['slug']['en']],
                [
                    'category_id' => $el['category_id'],
                    'name' => $el['name'],
                    'slug' => $el['slug'],
                    'short_description' => $el['short_description'],
                    'description' => $el['description'],
                    'specifications' => $el['specifications'],
                    'status' => 'published',
                    'sort_order' => $idx + 1,
                    'is_featured' => $el['is_featured'] ?? false,
                ]
            );
        }

        // 5. Project Categories
        $projectCat1 = ProjectCategory::updateOrCreate(['slug->en' => 'commercial'], ['name' => ['en' => 'Commercial Towers', 'ar' => 'الأبراج والمراكز التجارية'], 'slug' => ['en' => 'commercial', 'ar' => 'commercial'], 'sort_order' => 1]);
        $projectCat2 = ProjectCategory::updateOrCreate(['slug->en' => 'residential'], ['name' => ['en' => 'Luxury Residential', 'ar' => 'المجمعات السكنية الفاخرة'], 'slug' => ['en' => 'residential', 'ar' => 'residential'], 'sort_order' => 2]);
        $projectCat3 = ProjectCategory::updateOrCreate(['slug->en' => 'healthcare'], ['name' => ['en' => 'Healthcare & Medical', 'ar' => 'المستشفيات والمنشآت الطبية'], 'slug' => ['en' => 'healthcare', 'ar' => 'healthcare'], 'sort_order' => 3]);

        // 6. Sample Projects (6 items)
        $sampleProjects = [
            [
                'category_id' => $projectCat1->id,
                'title' => ['en' => 'New Cairo Financial Hub', 'ar' => 'المركز المالي بالقاهرة الجديدة'],
                'slug' => ['en' => 'new-cairo-financial-hub', 'ar' => 'new-cairo-financial-hub'],
                'short_description' => ['en' => 'Turnkey installation of 12 high-speed gearless elevators with intelligent destination dispatching.', 'ar' => 'تنفيذ متكامل لـ 12 مصعداً فائق السرعة بدون تروس بنظام توجيه الوجهات الذكي.'],
                'description' => ['en' => 'Engineered for maximum passenger throughput during morning peak hours with zero mechanical downtime.', 'ar' => 'تم التصميم الهندسي لاستيعاب أعلى كثافة ركاب في ساعات الذروة مع ضمان استمرارية التشغيل الكامل.'],
                'location' => ['en' => 'New Cairo, Egypt', 'ar' => 'القاهرة الجديدة، مصر'],
                'year' => 2025,
                'status' => 'Completed',
                'elevators_count' => 12,
                'service_type' => ['en' => 'Complete Supply & Installation', 'ar' => 'توريد وتركيب وتشغيل متكامل'],
                'is_featured' => true,
            ],
            [
                'category_id' => $projectCat2->id,
                'title' => ['en' => 'The Grand Palm Luxury Residences', 'ar' => 'كمبوند ذا جراند بالم السكني الفاخر'],
                'slug' => ['en' => 'the-grand-palm-luxury-residences', 'ar' => 'the-grand-palm-residences'],
                'short_description' => ['en' => 'Bespoke custom cabins with quiet hydraulic and traction systems across 8 residential villas.', 'ar' => 'مصاعد مخصصة بتصميم داخلي فاخر وأنظمة حركة فائقة الهدوء لـ 8 فيلات سكنية.'],
                'description' => ['en' => 'A masterclass in residential vertical integration with custom marble floors and bronze cladding.', 'ar' => 'تكامل معماري متميز مع أرضيات رخامية وتشطيبات برونزية فاخرة.'],
                'location' => ['en' => 'Sheikh Zayed City, Giza', 'ar' => 'مدينة الشيخ زايد، الجيزة'],
                'year' => 2024,
                'status' => 'Completed',
                'elevators_count' => 8,
                'service_type' => ['en' => 'Custom Engineering & Maintenance', 'ar' => 'تصنيع خاص وصيانة مستمرة'],
                'is_featured' => true,
            ],
            [
                'category_id' => $projectCat3->id,
                'title' => ['en' => 'Capital International Medical Complex', 'ar' => 'مجمع كابيتال الطبي الدولي'],
                'slug' => ['en' => 'capital-international-medical-complex', 'ar' => 'capital-medical-complex'],
                'short_description' => ['en' => 'Installation of 6 hospital bed elevators with specialized bactericidal ventilation and emergency priority dispatch.', 'ar' => 'تركيب 6 مصاعد أسرة طبية مع تهوية معقمة وأنظمة استدعاء الطوارئ الطبية.'],
                'description' => ['en' => 'Compliant with EN 81-20 safety norms and equipped with dual UPS battery emergency lowering systems.', 'ar' => 'مطابق للمواصفات القياسية الأوروبية EN 81-20 ومزود بوحدات هبوط اضطراري أوتوماتيكي.'],
                'location' => ['en' => 'New Administrative Capital', 'ar' => 'العاصمة الإدارية الجديدة'],
                'year' => 2025,
                'status' => 'Completed',
                'elevators_count' => 6,
                'service_type' => ['en' => 'Healthcare Systems Engineering', 'ar' => 'هندسة الأنظمة الطبية المتخصصة'],
                'is_featured' => true,
            ],
        ];

        foreach ($sampleProjects as $idx => $proj) {
            Project::updateOrCreate(
                ['slug->en' => $proj['slug']['en']],
                [
                    'category_id' => $proj['category_id'],
                    'title' => $proj['title'],
                    'slug' => $proj['slug'],
                    'short_description' => $proj['short_description'],
                    'description' => $proj['description'],
                    'location' => $proj['location'],
                    'year' => $proj['year'],
                    'status' => $proj['status'],
                    'elevators_count' => $proj['elevators_count'],
                    'service_type' => $proj['service_type'],
                    'is_featured' => $proj['is_featured'] ?? false,
                    'status_publish' => 'published',
                    'sort_order' => $idx + 1,
                ]
            );
        }

        // 7. Services (6 items)
        $servicesData = [
            [
                'title' => ['en' => 'Elevator Installation & Commissioning', 'ar' => 'توريد وتركيب واختبار المصاعد'],
                'slug' => ['en' => 'elevator-installation-commissioning', 'ar' => 'elevator-installation'],
                'description' => [
                    'en' => 'End-to-end engineering, shaft surveying, structural alignment, and certified commissioning for new construction.',
                    'ar' => 'دراسة هندسية متكاملة للآبار والمطابقة الإنشائية والتركيب الميكانيكي والكهربائي مع شهادات الاختبار والاعتماد.',
                ],
            ],
            [
                'title' => ['en' => 'Preventive Maintenance & Safety Inspections', 'ar' => 'الصيانة الوقائية والفحص الدوري الشامل'],
                'slug' => ['en' => 'preventive-maintenance-safety-inspections', 'ar' => 'preventive-maintenance'],
                'description' => [
                    'en' => 'Proactive 24/7 maintenance contracts with telemetry monitoring to prevent interruptions before they happen.',
                    'ar' => 'عقود صيانة دورية شاملة مع فرق استجابة سريعة على مدار الساعة لضمان استمرارية التشغيل التام.',
                ],
            ],
            [
                'title' => ['en' => 'Modernization & Performance Upgrades', 'ar' => 'تحديث وتطوير وتجديد المصاعد القائمة'],
                'slug' => ['en' => 'modernization-performance-upgrades', 'ar' => 'elevator-modernization'],
                'description' => [
                    'en' => 'Transforming aging vertical transportation with energy-efficient drives, modern controls, and refined cabin aesthetics.',
                    'ar' => 'إحلال وتجديد الماكينات ولوحات التحكم القديمة بأنظمة حديثة موفرة للطاقة مع تجديد ديكورات الكبائن.',
                ],
            ],
            [
                'title' => ['en' => 'Bespoke Architectural Cabin Design', 'ar' => 'تصميم وتنفيذ كبائن معمارية مخصصة'],
                'slug' => ['en' => 'bespoke-architectural-cabin-design', 'ar' => 'bespoke-cabin-design'],
                'description' => [
                    'en' => 'Tailored luxury finishes utilizing architectural bronze, etched metals, natural stone, and dynamic lighting.',
                    'ar' => 'تصميمات داخلية فاخرة للكبائن تجمع بين الرخام الطبيعي والفولاذ المقاوم للصدأ والإضاءة المعمارية المبتكرة.',
                ],
            ],
        ];

        foreach ($servicesData as $idx => $srv) {
            Service::updateOrCreate(
                ['slug->en' => $srv['slug']['en']],
                [
                    'title' => $srv['title'],
                    'slug' => $srv['slug'],
                    'description' => $srv['description'],
                    'sort_order' => $idx + 1,
                    'status' => 'published',
                ]
            );
        }

        // 8. Testimonials
        Testimonial::updateOrCreate(
            ['name' => 'Eng. Tarek Mansour'],
            [
                'role' => ['en' => 'Chief Development Officer', 'ar' => 'رئيس قطاع التطوير الهندسي'],
                'company' => 'Emaar Horizons Development',
                'quote' => [
                    'en' => 'EL DEEB delivered outstanding mechanical precision on our flagship tower. The ride quality and quietness exceed international standards.',
                    'ar' => 'قدمت شركة الديب دقة هندسية استثنائية في مشروع برجنا التجاري. الهدوء وسلاسة الحركة فاقتا التوقعات والمعايير العالمية.',
                ],
                'sort_order' => 1,
                'status' => 'published',
            ]
        );

        Testimonial::updateOrCreate(
            ['name' => 'Arch. Karim El-Sayed'],
            [
                'role' => ['en' => 'Principal Architect', 'ar' => 'المهندس المعماري الرئيسي'],
                'company' => 'Atelier Modern Architecture',
                'quote' => [
                    'en' => 'Their custom panoramic cabins integrated seamlessly into our atrium without compromising our minimalist architectural vision.',
                    'ar' => 'تكاملت مصاعدهم البانورامية الزجاجية بتناغم رائع مع التصميم المعماري للمبنى مع الحفاظ على روح الفخامة والبساطة.',
                ],
                'sort_order' => 2,
                'status' => 'published',
            ]
        );

        // 9. Partners
        $partnersData = ['Orascom Construction', 'Hassan Allam', 'Talaat Moustafa Group', 'Emaar Misr', 'Sodic Developments', 'Palm Hills'];
        foreach ($partnersData as $idx => $pName) {
            Partner::updateOrCreate(
                ['name' => $pName],
                [
                    'sort_order' => $idx + 1,
                    'status' => 'published',
                ]
            );
        }

        // 10. FAQs
        $faqsData = [
            [
                'question' => [
                    'en' => 'What safety standards and certifications do EL DEEB elevator systems comply with?',
                    'ar' => 'ما هي معايير واشتراطات السلامة العالمية التي تطبقها مصاعد الديب؟',
                ],
                'answer' => [
                    'en' => 'All EL DEEB systems are manufactured and installed strictly adhering to European safety standards EN 81-20 and EN 81-50, equipped with multi-stage overspeed governors, hydraulic buffers, and automatic rescue devices.',
                    'ar' => 'تلتزم كافة أنظمة مصاعد الديب بالمواصفات القياسية الأوروبية EN 81-20 و EN 81-50، وتزود بمنظومة أمان ميكانيكية وإلكترونية متعددة المراحل مع أجهزة هبوط اضطراري أوتوماتيكي عند انقطاع التيار الكهربائي.',
                ],
            ],
            [
                'question' => [
                    'en' => 'How does the emergency rescue system operate during a power outage?',
                    'ar' => 'كيف يعمل نظام الطوارئ الذكي في حال انقطاع التيار الكهربائي المفاجئ؟',
                ],
                'answer' => [
                    'en' => 'In case of power failure, the automated Automatic Rescue Device (ARD) immediately activates UPS backup batteries, safely guides the cabin to the nearest floor, and opens the doors for passenger egress.',
                    'ar' => 'عند انقطاع التيار، يعمل جهاز الإنقاذ الآلي (ARD) المعتمد على بطاريات UPS فوراً على توجيه الكابينة لأقرب طابق وفتح الأبواب تلقائياً لخروج الركاب بأمان تام.',
                ],
            ],
            [
                'question' => [
                    'en' => 'Can elevator cabins be customized to match our architectural interior design?',
                    'ar' => 'هل يمكن تصميم الكبائن وتخصيصها لتلائم الهوية المعمارية للمبنى؟',
                ],
                'answer' => [
                    'en' => 'Yes. We offer fully bespoke interior fabrication incorporating natural marble, bronze, titanium cladding, custom ceiling illumination, and touchless digital control panels.',
                    'ar' => 'نعم بكل تأكيد. نوفر إمكانية تفصيل وتخصيص الكبائن بالكامل، بما يشمل الأرضيات الرخامية، التشطيبات البرونزية، الإضاءة غير المباشرة، وشاشات العرض الذكية.',
                ],
            ],
        ];

        foreach ($faqsData as $idx => $faq) {
            Faq::updateOrCreate(
                ['question->en' => $faq['question']['en']],
                [
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'sort_order' => $idx + 1,
                    'status' => 'published',
                ]
            );
        }

        // 11. Blog Articles
        $artCat = ArticleCategory::updateOrCreate(['slug->en' => 'engineering'], ['name' => ['en' => 'Engineering & Technology', 'ar' => 'الهندسة والتكنولوجيا'], 'slug' => ['en' => 'engineering', 'ar' => 'engineering'], 'sort_order' => 1]);

        Article::updateOrCreate(
            ['slug->en' => 'the-future-of-gearless-elevator-traction'],
            [
                'category_id' => $artCat->id,
                'author_id' => 1,
                'title' => [
                    'en' => 'The Future of Gearless Elevator Traction in Modern High-Rise Architecture',
                    'ar' => 'مستقبل المحركات اللاترسية (Gearless) في ناطحات السحاب الحديثة',
                ],
                'slug' => [
                    'en' => 'the-future-of-gearless-elevator-traction',
                    'ar' => 'future-of-gearless-traction',
                ],
                'excerpt' => [
                    'en' => 'An in-depth analysis of synchronous permanent magnet technology and how it cuts energy consumption by up to 40%.',
                    'ar' => 'دراسة هندسية متخصصة حول تقنية المغناطيس الدائم المتزامن ودورها في خفض استهلاك الطاقة بنسبة تصل إلى 40%.',
                ],
                'content' => [
                    'en' => '<p>Permanent Magnet Synchronous Motor (PMSM) technology has revolutionized vertical transportation. By eliminating conventional worm gearboxes, mechanical friction is drastically reduced, delivering whisper-quiet motion and superior efficiency.</p>',
                    'ar' => '<p>أحدثت تكنولوجيا المحركات اللاترسية ذات المغناطيس الدائم ثورة حقيقية في كفاءة المصاعد، حيث أتاحت خفض الاحتكاك الميكانيكي والتخلص من الزيوت، مع توفير استهلاك الطاقة ونعومة فائقة في الحركة.</p>',
                ],
                'is_featured' => true,
                'status' => 'published',
                'publish_at' => now(),
                'reading_time' => 4,
            ]
        );
    }
}
