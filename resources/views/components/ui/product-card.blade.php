@props([
    'title',
    'category' => null,
    'description' => null,
    'image' => null,
    'url' => '#',
    'meta' => null,
])

<a href="{{ $url }}" {{ $attributes->merge(['class' => 'group block bg-white border border-[#C8C0B5] hover:border-[#A99776] transition-all duration-300 overflow-hidden shadow-xs hover:shadow-md flex flex-col']) }}>
    <!-- Image Area -->
    <div class="aspect-[16/10] w-full bg-[#172A35] overflow-hidden relative">
        <img 
            src="{{ $image ?: asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg') }}" 
            alt="{{ $title }}" 
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
            loading="lazy"
        >
    </div>

    <!-- Content Area -->
    <div class="p-6 md:p-8 flex-1 flex flex-col justify-start">
        @if($category)
            <div class="mb-4">
                <span class="inline-block bg-[#A99776] text-white px-5 py-1.5 rounded-full text-xs font-medium tracking-wide">
                    {{ $category }}
                </span>
            </div>
        @endif

        @if($meta)
            <div class="text-[11px] text-[#778087] font-medium mb-1">
                {{ $meta }}
            </div>
        @endif

        <h3 class="font-serif text-2xl md:text-[26px] font-normal text-[#172A35] group-hover:text-[#A99776] transition-colors leading-snug">
            {{ $title }}
        </h3>

        @if($description)
            <p class="text-xs sm:text-sm text-[#596269] mt-2.5 leading-relaxed line-clamp-2">
                {{ $description }}
            </p>
        @endif

        {{ $slot }}
    </div>
</a>
