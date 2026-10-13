<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($projects as $project)
        <x-ui.product-card
            :title="$project->title"
            :category="$project->category->name ?? 'Commercial'"
            :meta="$project->location . ' • ' . $project->year . ' (' . $project->elevators_count . ' ' . __('site.common.elevators_count') . ')'"
            :description="$project->short_description"
            :image="$project->getFirstMediaUrl('cover') ?: asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg')"
            :url="route('site.projects.show', ['locale' => app()->getLocale(), 'slug' => $project->slug])"
        />
    @empty
        <div class="col-span-full py-16 text-center text-[#778087] text-xs">
            {{ app()->getLocale() === 'ar' ? 'لا توجد مشروعات مطابقة لخيارات التصفية.' : 'No projects found matching the criteria.' }}
        </div>
    @endforelse
</div>

<div class="mt-12">
    {{ $projects->withQueryString()->links() }}
</div>
