@extends('layouts.admin')

@section('title', 'Design System Styleguide')
@section('header_title', 'Design System & Component Library (Section 13)')

@section('content')
<div class="space-y-12 max-w-5xl">
    <!-- Intro & Palette Tokens -->
    <div class="bg-white p-8 border border-[#E4DFD8]">
        <h2 class="text-xl font-serif font-bold text-[#172A35] mb-2">EL DEEB Architectural Design System</h2>
        <p class="text-xs text-[#596269] mb-6">
            Strict palette tokens, architectural hairline borders, and precision components.
        </p>

        <!-- Color Swatches -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
            <div class="p-4 bg-[#172A35] text-[#F5F1E8] border border-[#233642]">
                <div class="text-xs font-bold">Deep Navy</div>
                <div class="text-[10px] text-[#C8C0B5] mt-1">#172A35</div>
                <div class="text-[10px] text-[#A99776] mt-4 uppercase">Primary Dark</div>
            </div>

            <div class="p-4 bg-[#F5F1E8] text-[#172A35] border border-[#C8C0B5]">
                <div class="text-xs font-bold">Warm Ivory</div>
                <div class="text-[10px] text-[#596269] mt-1">#F5F1E8</div>
                <div class="text-[10px] text-[#A99776] mt-4 uppercase">Primary Light</div>
            </div>

            <div class="p-4 bg-[#C8C0B5] text-[#172A35] border border-[#ADA294]">
                <div class="text-xs font-bold">Warm Greige</div>
                <div class="text-[10px] text-[#596269] mt-1">#C8C0B5</div>
                <div class="text-[10px] text-[#172A35] mt-4 uppercase">Hairline Borders</div>
            </div>

            <div class="p-4 bg-[#596269] text-[#F5F1E8] border border-[#3E454B]">
                <div class="text-xs font-bold">Slate</div>
                <div class="text-[10px] text-[#C8C0B5] mt-1">#596269</div>
                <div class="text-[10px] text-[#F5F1E8] mt-4 uppercase">Secondary Text</div>
            </div>

            <div class="p-4 bg-[#A99776] text-[#0F1C23] border border-[#8A7755]">
                <div class="text-xs font-bold">Muted Champagne</div>
                <div class="text-[10px] text-[#0F1C23] mt-1">#A99776</div>
                <div class="text-[10px] text-[#0F1C23] mt-4 uppercase font-bold">Accent Only</div>
            </div>
        </div>
    </div>

    <!-- 1. Buttons Catalogue -->
    <div class="bg-white p-8 border border-[#E4DFD8]">
        <h3 class="text-sm font-bold uppercase tracking-[0.16em] text-[#172A35] mb-6 pb-2 border-b border-[#E4DFD8]">
            1. Buttons (Default, Hover, Disabled, Outline, Danger)
        </h3>

        <div class="flex flex-wrap items-center gap-4">
            <!-- Primary -->
            <button class="bg-[#172A35] hover:bg-[#A99776] text-[#F5F1E8] px-6 py-3 text-xs uppercase tracking-widest font-semibold transition-all">
                Primary Button
            </button>

            <!-- Secondary / Accent -->
            <button class="bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] px-6 py-3 text-xs uppercase tracking-widest font-semibold transition-all">
                Champagne CTA
            </button>

            <!-- Outline -->
            <button class="border border-[#172A35] hover:bg-[#172A35] hover:text-[#F5F1E8] text-[#172A35] px-6 py-3 text-xs uppercase tracking-widest font-semibold transition-all">
                Outline Architectural
            </button>

            <!-- Ghost -->
            <button class="hover:bg-[#F5F1E8] text-[#172A35] px-4 py-3 text-xs uppercase tracking-widest font-semibold transition-all">
                Ghost Link &rarr;
            </button>

            <!-- Danger -->
            <button class="bg-red-700 hover:bg-red-800 text-white px-5 py-3 text-xs uppercase tracking-wider font-semibold transition-all">
                Danger Action
            </button>

            <!-- Disabled -->
            <button disabled class="bg-[#E4DFD8] text-[#778087] px-6 py-3 text-xs uppercase tracking-widest font-semibold cursor-not-allowed">
                Disabled State
            </button>
        </div>
    </div>

    <!-- 2. Form Inputs -->
    <div class="bg-white p-8 border border-[#E4DFD8]">
        <h3 class="text-sm font-bold uppercase tracking-[0.16em] text-[#172A35] mb-6 pb-2 border-b border-[#E4DFD8]">
            2. Inputs & Form Controls
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#596269] mb-1.5">Text Input</label>
                <input type="text" placeholder="Standard text" class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-2.5 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#596269] mb-1.5">Select Dropdown</label>
                <select class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-2.5 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]">
                    <option>Passenger Elevators</option>
                    <option>Panoramic Observation</option>
                    <option>Freight / Heavy Duty</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-red-600 mb-1.5">Error State</label>
                <input type="text" value="Invalid input" class="w-full bg-red-50 border border-red-500 px-3.5 py-2.5 text-xs text-red-800 focus:outline-none">
                <span class="text-[10px] text-red-600 mt-1 block">This field is required.</span>
            </div>
        </div>
    </div>

    <!-- 3. Spec Table Component -->
    <div class="bg-white p-8 border border-[#E4DFD8]">
        <h3 class="text-sm font-bold uppercase tracking-[0.16em] text-[#172A35] mb-6 pb-2 border-b border-[#E4DFD8]">
            3. Technical Specifications Table (Section 5.4)
        </h3>

        <div class="overflow-x-auto border border-[#E4DFD8]">
            <table class="w-full text-xs text-start">
                <tbody class="divide-y divide-[#E4DFD8]">
                    <tr class="hover:bg-[#FAF8F4]">
                        <td class="px-5 py-3 font-semibold text-[#172A35] bg-[#FAF8F4] w-1/3">Rated Capacity</td>
                        <td class="px-5 py-3 text-[#596269]">630 kg – 2,500 kg (8 to 33 passengers)</td>
                    </tr>
                    <tr class="hover:bg-[#FAF8F4]">
                        <td class="px-5 py-3 font-semibold text-[#172A35] bg-[#FAF8F4] w-1/3">Rated Speed</td>
                        <td class="px-5 py-3 text-[#596269]">1.0 m/s – 4.0 m/s gearless traction</td>
                    </tr>
                    <tr class="hover:bg-[#FAF8F4]">
                        <td class="px-5 py-3 font-semibold text-[#172A35] bg-[#FAF8F4] w-1/3">Maximum Travel Height</td>
                        <td class="px-5 py-3 text-[#596269]">Up to 150 meters (45 stops)</td>
                    </tr>
                    <tr class="hover:bg-[#FAF8F4]">
                        <td class="px-5 py-3 font-semibold text-[#172A35] bg-[#FAF8F4] w-1/3">Control System</td>
                        <td class="px-5 py-3 text-[#596269]">Microprocessor VVVF Full Collective with IoT telemetry</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Alerts (Success, Warning, Error - Architectural Leading Bar) -->
    <div class="bg-white p-8 border border-[#E4DFD8]">
        <h3 class="text-sm font-bold uppercase tracking-[0.16em] text-[#172A35] mb-6 pb-2 border-b border-[#E4DFD8]">
            4. Alerts (Architectural Leading Colored Bar)
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-ui.alert 
                type="success" 
                title="Success" 
                message="Changes published successfully." 
            />

            <x-ui.alert 
                type="warning" 
                title="Warning" 
                message="Arabic translation needs review." 
            />

            <x-ui.alert 
                type="error" 
                title="Error" 
                message="Alt text is required for this image." 
            />
        </div>
    </div>

    <!-- 5. Product Card Component (Hero Photo, Capsule Chip, Serif Title, Clean Excerpt) -->
    <div class="bg-white p-8 border border-[#E4DFD8]">
        <h3 class="text-sm font-bold uppercase tracking-[0.16em] text-[#172A35] mb-6 pb-2 border-b border-[#E4DFD8]">
            5. Product Card (Architectural Card Architecture)
        </h3>

        <div class="max-w-md">
            <x-ui.product-card
                title="Panoramic Series P"
                category="Panoramic Series P"
                description="Configurable capacity, finish and drive options."
                :image="asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg')"
                url="#"
            />
        </div>
    </div>
</div>
@endsection
