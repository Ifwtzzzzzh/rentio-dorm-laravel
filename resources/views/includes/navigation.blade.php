<div id="BottomNav" class="relative flex w-full h-[138px] shrink-0">
    <nav class="fixed bottom-5 w-full max-w-[640px] px-5 z-10">
        <div class="grid grid-cols-4 h-fit rounded-[40px] justify-between py-4 px-5 bg-ngekos-black">
            <a href="{{ route('home') }}" class="flex flex-col items-center text-center gap-2">
                <img src="assets/images/icons/global-green{{ request()->routeIs('home') ? '-green' : '' }}.svg" class="w-8 h-8 flex shrink-0" alt="icon">
                <span class="font-semibold text-sm text-white">Discover</span>
            </a>
            <a href="{{ route('check-booking') }}" class="flex flex-col items-center text-center gap-2">
                <img src="assets/images/icons/note-favorite{{ request()->routeIs('check-bookings') ? '-green' : '' }}.svg" class="w-8 h-8 flex shrink-0" alt="icon">
                <span class="font-semibold text-sm text-white">Orders</span>
            </a>
            <a href="{{ route('find-kos') }}" class="flex flex-col items-center text-center gap-2">
                <img src="assets/images/icons/search-status{{ request()->routeIs('find-kos') ? '-green' : '' }}.svg" class="w-8 h-8 flex shrink-0" alt="icon">
                <span class="font-semibold text-sm text-white">Find</span>
            </a>
            <a href="#" class="flex flex-col items-center text-center gap-2">
                <img src="assets/images/icons/24-support{{ request()->routeIs('help') ? '-green' : '' }}.svg" class="w-8 h-8 flex shrink-0" alt="icon">
                <span class="font-semibold text-sm text-white">Help</span>
            </a>
        </div>
    </nav>
</div>
