<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of all CMS and Landing pages.
     */
    public function index(): View
    {
        $this->ensureDefaultPagesExist();

        $pages = Page::withCount('sections')->orderBy('id')->get();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the edit form for a specific page.
     */
    public function edit(Page $page): View
    {
        $page->load('sections');

        if ($page->key === 'home') {
            return view('admin.pages.edit-home', compact('page'));
        }

        if ($page->key === 'about') {
            return view('admin.pages.edit-about', compact('page'));
        }

        return view('admin.pages.edit-legal', compact('page'));
    }

    /**
     * Update page content.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        if ($page->key === 'home') {
            return $this->updateHome($request, $page);
        }

        if ($page->key === 'about') {
            return $this->updateAbout($request, $page);
        }

        return $this->updateLegal($request, $page);
    }

    /**
     * Update Home page sections.
     */
    protected function updateHome(Request $request, Page $page): RedirectResponse
    {
        $request->validate([
            'hero_bg_image' => 'nullable|image|max:10240',
            'about_image' => 'nullable|image|max:10240',
        ]);

        // 1. Hero Section
        $heroData = $page->getSectionData('hero');
        if ($request->hasFile('hero_bg_image')) {
            $path = $request->file('hero_bg_image')->store('pages', 'public');
            $heroData['bg_image'] = asset('storage/' . $path);
        }
        $heroData['eyebrow'] = [
            'ar' => $request->input('hero_eyebrow_ar'),
            'en' => $request->input('hero_eyebrow_en'),
        ];
        $heroData['headline'] = [
            'ar' => $request->input('hero_headline_ar'),
            'en' => $request->input('hero_headline_en'),
        ];
        $heroData['description'] = [
            'ar' => $request->input('hero_description_ar'),
            'en' => $request->input('hero_description_en'),
        ];
        $heroData['cta_primary'] = [
            'text' => [
                'ar' => $request->input('hero_cta1_text_ar'),
                'en' => $request->input('hero_cta1_text_en'),
            ],
            'url' => $request->input('hero_cta1_url'),
        ];
        $heroData['cta_secondary'] = [
            'text' => [
                'ar' => $request->input('hero_cta2_text_ar'),
                'en' => $request->input('hero_cta2_text_en'),
            ],
            'url' => $request->input('hero_cta2_url'),
        ];
        $this->saveSection($page, 'hero', $heroData, 1);

        // 2. Stats Bar Section
        $statsData = [
            'items' => [
                [
                    'value' => $request->input('stat_1_value', '500+'),
                    'label' => ['ar' => $request->input('stat_1_label_ar'), 'en' => $request->input('stat_1_label_en')],
                ],
                [
                    'value' => $request->input('stat_2_value', '99.9%'),
                    'label' => ['ar' => $request->input('stat_2_label_ar'), 'en' => $request->input('stat_2_label_en')],
                ],
                [
                    'value' => $request->input('stat_3_value', '15+'),
                    'label' => ['ar' => $request->input('stat_3_label_ar'), 'en' => $request->input('stat_3_label_en')],
                ],
                [
                    'value' => $request->input('stat_4_value', '24/7'),
                    'label' => ['ar' => $request->input('stat_4_label_ar'), 'en' => $request->input('stat_4_label_en')],
                ],
            ],
        ];
        $this->saveSection($page, 'stats', $statsData, 2);

        // 3. About Teaser Section
        $aboutData = $page->getSectionData('about_teaser');
        if ($request->hasFile('about_image')) {
            $path = $request->file('about_image')->store('pages', 'public');
            $aboutData['image'] = asset('storage/' . $path);
        }
        $aboutData['eyebrow'] = [
            'ar' => $request->input('about_eyebrow_ar'),
            'en' => $request->input('about_eyebrow_en'),
        ];
        $aboutData['headline'] = [
            'ar' => $request->input('about_headline_ar'),
            'en' => $request->input('about_headline_en'),
        ];
        $aboutData['description'] = [
            'ar' => $request->input('about_description_ar'),
            'en' => $request->input('about_description_en'),
        ];
        $aboutData['badge_title'] = [
            'ar' => $request->input('about_badge_title_ar'),
            'en' => $request->input('about_badge_title_en'),
        ];
        $aboutData['badge_subtitle'] = [
            'ar' => $request->input('about_badge_subtitle_ar'),
            'en' => $request->input('about_badge_subtitle_en'),
        ];
        $this->saveSection($page, 'about_teaser', $aboutData, 3);

        // 4. Engineering & Safety Pillars
        $pillarsData = [
            'eyebrow' => [
                'ar' => $request->input('pillars_eyebrow_ar'),
                'en' => $request->input('pillars_eyebrow_en'),
            ],
            'headline' => [
                'ar' => $request->input('pillars_headline_ar'),
                'en' => $request->input('pillars_headline_en'),
            ],
            'items' => [
                [
                    'title' => ['ar' => $request->input('pillar_1_title_ar'), 'en' => $request->input('pillar_1_title_en')],
                    'desc' => ['ar' => $request->input('pillar_1_desc_ar'), 'en' => $request->input('pillar_1_desc_en')],
                ],
                [
                    'title' => ['ar' => $request->input('pillar_2_title_ar'), 'en' => $request->input('pillar_2_title_en')],
                    'desc' => ['ar' => $request->input('pillar_2_desc_ar'), 'en' => $request->input('pillar_2_desc_en')],
                ],
                [
                    'title' => ['ar' => $request->input('pillar_3_title_ar'), 'en' => $request->input('pillar_3_title_en')],
                    'desc' => ['ar' => $request->input('pillar_3_desc_ar'), 'en' => $request->input('pillar_3_desc_en')],
                ],
                [
                    'title' => ['ar' => $request->input('pillar_4_title_ar'), 'en' => $request->input('pillar_4_title_en')],
                    'desc' => ['ar' => $request->input('pillar_4_desc_ar'), 'en' => $request->input('pillar_4_desc_en')],
                ],
            ],
        ];
        $this->saveSection($page, 'pillars', $pillarsData, 4);

        // 5. Global CTA
        $ctaData = [
            'eyebrow' => [
                'ar' => $request->input('cta_eyebrow_ar'),
                'en' => $request->input('cta_eyebrow_en'),
            ],
            'headline' => [
                'ar' => $request->input('cta_headline_ar'),
                'en' => $request->input('cta_headline_en'),
            ],
            'description' => [
                'ar' => $request->input('cta_description_ar'),
                'en' => $request->input('cta_description_en'),
            ],
            'btn_text' => [
                'ar' => $request->input('cta_btn_text_ar'),
                'en' => $request->input('cta_btn_text_en'),
            ],
            'btn_url' => $request->input('cta_btn_url'),
        ];
        $this->saveSection($page, 'cta', $ctaData, 5);

        return redirect()->route('admin.pages.edit', $page)->with('success', 'تم حفظ وتحديث محتوى الصفحة الرئيسية بنجاح.');
    }

    /**
     * Update About Us page sections.
     */
    protected function updateAbout(Request $request, Page $page): RedirectResponse
    {
        $request->validate([
            'about_image' => 'nullable|image|max:10240',
        ]);

        // 1. Hero
        $heroData = [
            'eyebrow' => [
                'ar' => $request->input('hero_eyebrow_ar'),
                'en' => $request->input('hero_eyebrow_en'),
            ],
            'headline' => [
                'ar' => $request->input('hero_headline_ar'),
                'en' => $request->input('hero_headline_en'),
            ],
            'description' => [
                'ar' => $request->input('hero_description_ar'),
                'en' => $request->input('hero_description_en'),
            ],
        ];
        $this->saveSection($page, 'hero', $heroData, 1);

        // 2. Vision, Mission & Story
        $storyData = $page->getSectionData('vision_mission');
        if ($request->hasFile('about_image')) {
            $path = $request->file('about_image')->store('pages', 'public');
            $storyData['image'] = asset('storage/' . $path);
        }
        $storyData['headline'] = [
            'ar' => $request->input('story_headline_ar'),
            'en' => $request->input('story_headline_en'),
        ];
        $storyData['story'] = [
            'ar' => $request->input('story_text_ar'),
            'en' => $request->input('story_text_en'),
        ];
        $storyData['vision_title'] = [
            'ar' => $request->input('vision_title_ar'),
            'en' => $request->input('vision_title_en'),
        ];
        $storyData['vision_text'] = [
            'ar' => $request->input('vision_text_ar'),
            'en' => $request->input('vision_text_en'),
        ];
        $storyData['mission_title'] = [
            'ar' => $request->input('mission_title_ar'),
            'en' => $request->input('mission_title_en'),
        ];
        $storyData['mission_text'] = [
            'ar' => $request->input('mission_text_ar'),
            'en' => $request->input('mission_text_en'),
        ];
        $this->saveSection($page, 'vision_mission', $storyData, 2);

        return redirect()->route('admin.pages.edit', $page)->with('success', 'تم حفظ وتحديث محتوى صفحة عن الشركة بنجاح.');
    }

    /**
     * Update Legal CMS page (Privacy, Terms).
     */
    protected function updateLegal(Request $request, Page $page): RedirectResponse
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
        ]);

        $page->setTranslation('title', 'ar', $request->title_ar);
        $page->setTranslation('title', 'en', $request->title_en);
        $page->save();

        $contentData = [
            'content' => [
                'ar' => $request->content_ar,
                'en' => $request->content_en,
            ],
        ];
        $this->saveSection($page, 'legal_content', $contentData, 1);

        return redirect()->route('admin.pages.edit', $page)->with('success', 'تم تحديث الصفحة بنجاح.');
    }

    /**
     * Helper to update or create section data.
     */
    protected function saveSection(Page $page, string $type, array $data, int $sortOrder): void
    {
        PageSection::updateOrCreate(
            ['page_id' => $page->id, 'type' => $type],
            [
                'data' => $data,
                'is_enabled' => true,
                'sort_order' => $sortOrder,
            ]
        );
    }

    /**
     * Ensure default pages exist in database.
     */
    protected function ensureDefaultPagesExist(): void
    {
        Page::firstOrCreate(
            ['key' => 'home'],
            [
                'title' => ['ar' => 'الصفحة الرئيسية', 'en' => 'Home Page'],
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        Page::firstOrCreate(
            ['key' => 'about'],
            [
                'title' => ['ar' => 'عن الشركة والريادة الهندسية', 'en' => 'About EL DEEB'],
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        Page::firstOrCreate(
            ['key' => 'privacy'],
            [
                'title' => ['ar' => 'سياسة الخصوصية وحماية البيانات', 'en' => 'Privacy Policy'],
                'status' => 'published',
                'published_at' => now(),
            ]
        );

        Page::firstOrCreate(
            ['key' => 'terms'],
            [
                'title' => ['ar' => 'الشروط والأحكام والضمان الفني', 'en' => 'Terms & Conditions'],
                'status' => 'published',
                'published_at' => now(),
            ]
        );
    }
}
