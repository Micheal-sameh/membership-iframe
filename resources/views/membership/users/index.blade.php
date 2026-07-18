@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'إدارة المستخدمين' : 'Manage Users' }} — {{ $isRtl ? 'أبو رواش' : 'Ava Rewase' }}</title>
    @include('membership.partials.head-assets')
</head>
<body class="min-h-screen flex flex-col bg-surface-container-low text-on-background antialiased">

    @include('membership.partials.nav')

    <main class="flex-1 p-6">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="font-headline text-2xl font-medium text-primary">{{ $isRtl ? 'إدارة المستخدمين' : 'Manage Users' }}</h1>
                    <p class="text-on-surface-variant text-sm mt-1">
                        {{ $isRtl
                            ? $users->count() . ' مستخدم إجمالاً — ' . $users->where('is_active', true)->count() . ' نشط'
                            : $users->count() . ' total users — ' . $users->where('is_active', true)->count() . ' active' }}
                    </p>
                </div>
                <a href="{{ route('membership.users.create') }}"
                   class="h-11 px-5 bg-primary hover:bg-primary-container text-white font-semibold rounded-lg transition-all active:scale-[0.98] text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                    {{ $isRtl ? 'إضافة مستخدم' : 'Add User' }}
                </a>
            </div>

            @if(session('status') === 'user-created')
            <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                {{ $isRtl ? 'تم إنشاء المستخدم بنجاح.' : 'User created successfully.' }}
            </div>
            @elseif(session('status') === 'user-updated')
            <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                {{ $isRtl ? 'تم تحديث المستخدم بنجاح.' : 'User updated successfully.' }}
            </div>
            @elseif(session('status') === 'password-updated')
            <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                {{ $isRtl ? 'تم تحديث كلمة المرور بنجاح.' : 'Password updated successfully.' }}
            </div>
            @endif

            <div class="bg-surface-container-lowest rounded-xl login-card-shadow border border-secondary/10 overflow-hidden">
                @if($users->isEmpty())
                    <div class="p-12 text-center">
                        <div class="mx-auto w-14 h-14 rounded-2xl bg-secondary-container/30 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-secondary text-3xl">group_off</span>
                        </div>
                        <p class="text-on-surface-variant text-sm">{{ $isRtl ? 'لا يوجد مستخدمون بعد.' : 'No users yet.' }}</p>
                    </div>
                @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-surface-container-high text-left bg-surface-container-low/50">
                            <th class="px-4 py-3 font-semibold text-on-surface-variant">{{ $isRtl ? 'المستخدم' : 'User' }}</th>
                            <th class="px-4 py-3 font-semibold text-on-surface-variant">{{ $isRtl ? 'الدور' : 'Role' }}</th>
                            <th class="px-4 py-3 font-semibold text-on-surface-variant">{{ $isRtl ? 'المصادقة الثنائية' : '2FA' }}</th>
                            <th class="px-4 py-3 font-semibold text-on-surface-variant">{{ $isRtl ? 'الحالة' : 'Status' }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr class="border-b border-surface-container-high last:border-0 hover:bg-surface-container-low/60 transition-colors {{ ! $u->is_active ? 'opacity-60' : '' }}">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-semibold text-xs flex-shrink-0">
                                        {{ collect(explode(' ', $u->name))->map(fn($p) => mb_substr($p, 0, 1))->take(2)->implode('') }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-medium text-on-background truncate">{{ $u->name }}</div>
                                        <div class="text-on-surface-variant text-xs truncate">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($u->roles->isNotEmpty())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-secondary-container/30 text-secondary text-xs font-semibold">
                                        {{ $u->roles->pluck('name')->implode(', ') }}
                                    </span>
                                @else
                                    <span class="text-on-surface-variant text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($u->mfa_enabled)
                                    <span class="inline-flex items-center gap-1 text-green-700 text-xs font-semibold">
                                        <span class="material-symbols-outlined text-sm">verified_user</span>
                                        {{ $isRtl ? 'مفعّلة' : 'Enabled' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-on-surface-variant text-xs">
                                        <span class="material-symbols-outlined text-sm">gpp_maybe</span>
                                        {{ $isRtl ? 'غير مفعّلة' : 'Disabled' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($u->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-50 text-green-700 text-xs font-semibold">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        {{ $isRtl ? 'نشط' : 'Active' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-50 text-red-700 text-xs font-semibold">
                                        <span class="material-symbols-outlined text-sm">block</span>
                                        {{ $isRtl ? 'غير نشط' : 'Inactive' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('membership.users.edit', $u) }}"
                                   class="inline-flex items-center gap-1 text-primary hover:text-secondary transition-colors text-xs font-semibold">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                    {{ $isRtl ? 'تعديل' : 'Edit' }}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
