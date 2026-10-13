<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Elevator;
use App\Models\ElevatorCategory;
use App\Models\Faq;
use App\Models\MediaFolder;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminModulesTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::first() ?? User::factory()->create();
        if (! $this->admin->hasRole('Super Admin')) {
            $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
            $this->admin->assignRole($role);
        }
    }

    public function test_admin_can_access_all_module_index_pages(): void
    {
        $routes = [
            'admin.dashboard',
            'admin.pages.index',
            'admin.elevators.index',
            'admin.projects.index',
            'admin.services.index',
            'admin.blog.index',
            'admin.testimonials.index',
            'admin.partners.index',
            'admin.faqs.index',
            'admin.messages.index',
            'admin.media.index',
            'admin.users.index',
            'admin.roles.index',
            'admin.activity.index',
            'admin.settings.index',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($this->admin)->get(route($route));
            $response->assertStatus(200);
        }
    }

    public function test_admin_can_edit_and_update_home_page(): void
    {
        $page = Page::firstOrCreate(
            ['key' => 'home'],
            ['title' => ['ar' => 'الرئيسية', 'en' => 'Home']]
        );

        $response = $this->actingAs($this->admin)->get(route('admin.pages.edit', $page));
        $response->assertStatus(200);

        $updateResponse = $this->actingAs($this->admin)->put(route('admin.pages.update', $page), [
            'hero_eyebrow_ar' => 'شركة الديب الهندسية',
            'hero_eyebrow_en' => 'EL DEEB Engineering',
            'hero_headline_ar' => 'عنوان تجريبي محدث',
            'hero_headline_en' => 'Updated Test Headline',
            'hero_description_ar' => 'وصف تجريبي',
            'hero_description_en' => 'Test description',
            'stat_1_value' => '650+',
            'stat_1_label_ar' => 'مصعد مركب',
            'stat_1_label_en' => 'Installed',
        ]);

        $updateResponse->assertRedirect(route('admin.pages.edit', $page));
        $this->assertEquals('عنوان تجريبي محدث', $page->fresh()->getSectionData('hero')['headline']['ar']);

        // Check that frontend renders the updated bilingual headline
        $frontendAr = $this->get('/ar');
        $frontendAr->assertStatus(200);
        $frontendAr->assertSee('عنوان تجريبي محدث');

        $frontendEn = $this->get('/en');
        $frontendEn->assertStatus(200);
        $frontendEn->assertSee('Updated Test Headline');
    }

    public function test_admin_can_create_and_delete_faq(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.faqs.store'), [
            'question_ar' => 'ما هي فترة الضمان؟',
            'question_en' => 'What is warranty period?',
            'answer_ar' => 'ضمان شامل لمدة 10 سنوات على الماكينات.',
            'answer_en' => '10 years comprehensive warranty on machines.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $response->assertRedirect(route('admin.faqs.index'));
        $faq = Faq::where('question->en', 'What is warranty period?')->first();
        $this->assertNotNull($faq);

        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.faqs.destroy', $faq));
        $deleteResponse->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    public function test_admin_can_create_and_delete_testimonial(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.store'), [
            'name' => 'Eng. Tarek',
            'company' => 'Emaar Misr',
            'role_ar' => 'مدير المشروعات',
            'role_en' => 'Project Director',
            'quote_ar' => 'خدمة استثنائية والتزام تام بالمواعيد.',
            'quote_en' => 'Exceptional service and punctuality.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $response->assertRedirect(route('admin.testimonials.index'));
        $testimonial = Testimonial::where('name', 'Eng. Tarek')->first();
        $this->assertNotNull($testimonial);

        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.testimonials.destroy', $testimonial));
        $deleteResponse->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    public function test_admin_can_create_and_delete_partner(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('partner-logo.png', 200, 80);

        $response = $this->actingAs($this->admin)->post(route('admin.partners.store'), [
            'name' => 'Orascom Construction',
            'url' => 'https://orascom.com',
            'logo' => $file,
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $response->assertRedirect();
        $partner = Partner::where('name', 'Orascom Construction')->first();
        $this->assertNotNull($partner);

        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.partners.destroy', $partner));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('partners', ['id' => $partner->id]);
    }

    public function test_admin_can_create_media_folder(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.media.folder.store'), [
            'name' => 'Catalogues 2026',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('media_folders', ['name' => 'Catalogues 2026']);
    }

    public function test_admin_can_manage_users_and_roles(): void
    {
        $role = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
            'name' => 'Test Staff',
            'email' => 'staff@eldeeb.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
            'roles' => ['Editor'],
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $newUser = User::where('email', 'staff@eldeeb.com')->first();
        $this->assertNotNull($newUser);
        $this->assertTrue($newUser->hasRole('Editor'));
    }

    public function test_admin_can_access_edit_pages_and_update_article(): void
    {
        $cat = ArticleCategory::create([
            'name' => ['ar' => 'تصنيف تجريبي', 'en' => 'Test Cat'],
            'slug' => ['ar' => 'test-cat-ar', 'en' => 'test-cat-en'],
            'sort_order' => 1,
        ]);

        $article = Article::create([
            'category_id' => $cat->id,
            'author_id' => $this->admin->id,
            'title' => ['ar' => 'عنوان تجريبي', 'en' => 'Test Title'],
            'slug' => ['ar' => 'test-article-ar', 'en' => 'test-article-en'],
            'excerpt' => ['ar' => 'مختصر', 'en' => 'Excerpt'],
            'content' => ['ar' => '<p>محتوى</p>', 'en' => '<p>Content</p>'],
            'status' => 'published',
            'publish_at' => now(),
        ]);

        $editResponse = $this->actingAs($this->admin)->get(route('admin.blog.edit', $article));
        $editResponse->assertStatus(200);

        $updateResponse = $this->actingAs($this->admin)->put(route('admin.blog.update', $article), [
            'category_id' => $cat->id,
            'title_ar' => 'عنوان محدث',
            'title_en' => 'Updated Title',
            'slug_ar' => 'updated-title-ar',
            'slug_en' => 'updated-title-en',
            'excerpt_ar' => 'مختصر محدث',
            'excerpt_en' => 'Updated Excerpt',
            'content_ar' => '<p>محتوى محدث</p>',
            'content_en' => '<p>Updated Content</p>',
            'status' => 'published',
        ]);

        $updateResponse->assertRedirect(route('admin.blog.index'));
        $article->refresh();
        $this->assertEquals('عنوان محدث', $article->getTranslation('title', 'ar'));
    }

    public function test_admin_can_delete_elevator_category_with_attached_elevators(): void
    {
        $category = ElevatorCategory::create([
            'name' => ['ar' => 'تصنيف اختبار', 'en' => 'Test Cat'],
            'slug' => ['ar' => 'test-cat', 'en' => 'test-cat'],
            'sort_order' => 1,
            'status' => 'published',
        ]);

        $elevator = Elevator::create([
            'category_id' => $category->id,
            'name' => ['ar' => 'مصعد تجريبي', 'en' => 'Test Elevator'],
            'slug' => ['ar' => 'test-elev', 'en' => 'test-elev'],
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.elevator-categories.destroy', $category));
        $response->assertRedirect();
        $this->assertDatabaseMissing('elevator_categories', ['id' => $category->id]);
        $elevator->refresh();
        $this->assertNull($elevator->category_id);
    }

    public function test_admin_can_update_partner_details(): void
    {
        $partner = Partner::create([
            'name' => 'Original Partner',
            'url' => 'https://original.com',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.partners.update', $partner), [
            'name' => 'Updated Partner Name',
            'url' => 'https://updated.com',
            'status' => 'draft',
            'sort_order' => 5,
        ]);

        $response->assertRedirect();
        $partner->refresh();
        $this->assertEquals('Updated Partner Name', $partner->name);
        $this->assertEquals('https://updated.com', $partner->url);
        $this->assertEquals('draft', $partner->status);
        $this->assertEquals(5, $partner->sort_order);
    }

    public function test_role_edit_page_displays_arabic_permission_descriptions(): void
    {
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
        $role = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'web']);

        // Test in Arabic locale (default app or session)
        app()->setLocale('ar');
        session(['locale' => 'ar']);

        $response = $this->actingAs($this->admin)->get(route('admin.roles.edit', $role));
        $response->assertStatus(200);
        $response->assertSee('(عرض وقراءة المصاعد)');
        $response->assertSee('(إضافة مصعد جديد)');
        $response->assertSee('(حذف مصعد)');
        $response->assertSee('المصاعد والمنتجات (Elevators)');
    }

    public function test_admin_can_toggle_between_arabic_and_english(): void
    {
        // 1. Default load should be Arabic with RTL
        $responseAr = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $responseAr->assertStatus(200);
        $responseAr->assertSee('dir="rtl"', false);
        $responseAr->assertSee('لوحة التحكم');

        // 2. Switch to English
        $switchEn = $this->actingAs($this->admin)->get(route('admin.switch-locale', 'en'));
        $switchEn->assertSessionHas('locale', 'en');

        $responseEn = $this->actingAs($this->admin)->withSession(['locale' => 'en'])->get(route('admin.dashboard'));
        $responseEn->assertStatus(200);
        $responseEn->assertSee('dir="ltr"', false);
        $responseEn->assertSee('Dashboard');

        // 3. Switch back to Arabic
        $switchAr = $this->actingAs($this->admin)->get(route('admin.switch-locale', 'ar'));
        $switchAr->assertSessionHas('locale', 'ar');

        $responseAr2 = $this->actingAs($this->admin)->withSession(['locale' => 'ar'])->get(route('admin.dashboard'));
        $responseAr2->assertStatus(200);
        $responseAr2->assertSee('dir="rtl"', false);
        $responseAr2->assertSee('لوحة التحكم');
    }
}
