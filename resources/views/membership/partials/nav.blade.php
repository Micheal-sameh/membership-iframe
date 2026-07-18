@php
    $isRtl = app()->getLocale() === 'ar';
    $navLink = function (string $routeName, string $pattern, string $label, string $icon) use ($isRtl) {
        $active = request()->routeIs($pattern);
        $classes = $active
            ? 'bg-primary/10 text-primary'
            : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high';

        return '<a href="' . route($routeName) . '" class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-md transition-colors ' . $classes . '">'
            . '<span class="material-symbols-outlined text-base">' . $icon . '</span>'
            . '<span class="hidden sm:inline">' . $label . '</span>'
            . '</a>';
    };
@endphp
<header class="bg-surface-container-lowest border-b border-surface-container-high flex-shrink-0">
    <div class="px-4 sm:px-6 h-14 flex items-center gap-3">
        <a href="{{ route('membership.portal') }}" class="flex items-center gap-2.5 flex-1 min-w-0">
            <div class="w-7 h-7 rounded-lg bg-primary flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-white text-lg">groups</span>
            </div>
            <span class="font-headline text-sm font-semibold text-primary truncate">{{ $isRtl ? 'بوابة الأعضاء' : 'Membership Portal' }}</span>
        </a>

        <nav class="flex items-center gap-1">
            {!! $navLink('membership.portal', 'membership.portal', $isRtl ? 'الرئيسية' : 'Portal', 'home') !!}
            @if(Auth::user()->hasRole('admin'))
                {!! $navLink('membership.users.index', 'membership.users.*', $isRtl ? 'إدارة المستخدمين' : 'Manage Users', 'admin_panel_settings') !!}
            @endif
            {!! $navLink('membership.profile.edit', 'membership.profile.*', $isRtl ? 'ملفي الشخصي' : 'My Profile', 'account_circle') !!}
        </nav>

        <div class="flex items-center gap-2 ps-2 border-s border-surface-container-high">
            <span class="text-xs text-on-surface-variant hidden md:inline truncate max-w-[180px]">{{ Auth::user()->email }}</span>
            <form method="POST" action="{{ route('membership.logout') }}" class="m-0">
                @csrf
                <button type="submit"
                        class="flex items-center gap-1.5 text-xs font-semibold text-on-surface-variant hover:text-red-600 transition-colors px-3 py-1.5 rounded-md hover:bg-red-50">
                    <span class="material-symbols-outlined text-base">logout</span>
                    <span class="hidden sm:inline">{{ $isRtl ? 'خروج' : 'Sign Out' }}</span>
                </button>
            </form>
        </div>
    </div>
</header>
