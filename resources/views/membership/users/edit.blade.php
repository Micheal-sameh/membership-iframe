@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'تعديل المستخدم' : 'Edit User' }} — {{ $isRtl ? 'أبو رواش' : 'Ava Rewase' }}</title>
    @include('membership.partials.head-assets')
</head>
<body class="min-h-screen flex flex-col bg-surface-container-low text-on-background antialiased">

    @include('membership.partials.nav')

    <main class="flex-1 flex items-start justify-center p-6">
        <div class="w-full max-w-lg mt-8 space-y-6">
            <div class="flex items-center gap-2">
                <a href="{{ route('membership.users.index') }}" class="text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="font-headline text-2xl font-medium text-primary">{{ $isRtl ? 'تعديل المستخدم' : 'Edit User' }}</h1>
            </div>

            {{-- Account details --}}
            <div class="bg-surface-container-lowest p-6 rounded-xl login-card-shadow border border-secondary/10">
                <h2 class="font-semibold text-on-background mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">person</span>
                    {{ $isRtl ? 'بيانات الحساب' : 'Account Details' }}
                </h2>

                @if(session('status') === 'user-updated')
                <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">check_circle</span>
                    {{ $isRtl ? 'تم تحديث البيانات بنجاح.' : 'Details updated successfully.' }}
                </div>
                @endif

                <form method="POST" action="{{ route('membership.users.update', $editUser) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="name">
                            {{ $isRtl ? 'الاسم' : 'Name' }}
                        </label>
                        <input id="name" name="name" type="text" value="{{ old('name', $editUser->name) }}"
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                        @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="email">
                            {{ $isRtl ? 'البريد الإلكتروني' : 'Email Address' }}
                        </label>
                        <input id="email" name="email" type="email" value="{{ old('email', $editUser->email) }}"
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                        @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="role">
                            {{ $isRtl ? 'الدور' : 'Role' }}
                        </label>
                        <select id="role" name="role"
                                class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                            <option value="">{{ $isRtl ? '— بدون دور —' : '— No role —' }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" @selected(old('role', $editUser->roles->pluck('name')->first()) === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="flex items-center gap-3 p-3 rounded-lg border border-outline-variant cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               @checked(old('is_active', $editUser->is_active))
                               class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-secondary">
                        <span class="text-sm">
                            <span class="font-semibold text-on-background">{{ $isRtl ? 'الحساب نشط' : 'Account active' }}</span>
                            <span class="block text-on-surface-variant text-xs">{{ $isRtl ? 'إلغاء التفعيل يمنع هذا المستخدم من تسجيل الدخول فورًا.' : 'Deactivating immediately blocks this user from logging in.' }}</span>
                        </span>
                    </label>

                    <button type="submit"
                            class="w-full h-12 bg-primary hover:bg-primary-container text-white font-semibold rounded-lg transition-all active:scale-[0.98] text-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">save</span>
                        {{ $isRtl ? 'حفظ البيانات' : 'Save Details' }}
                    </button>
                </form>
            </div>

            {{-- Password --}}
            <div class="bg-surface-container-lowest p-6 rounded-xl login-card-shadow border border-secondary/10">
                <h2 class="font-semibold text-on-background mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">lock</span>
                    {{ $isRtl ? 'كلمة المرور' : 'Password' }}
                </h2>

                @if(session('status') === 'password-updated')
                <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">check_circle</span>
                    {{ $isRtl ? 'تم تحديث كلمة المرور بنجاح.' : 'Password updated successfully.' }}
                </div>
                @endif

                <form method="POST" action="{{ route('membership.users.password', $editUser) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="password">
                            {{ $isRtl ? 'كلمة المرور الجديدة' : 'New Password' }}
                        </label>
                        <input id="password" name="password" type="password" autocomplete="new-password"
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                        @error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="password_confirmation">
                            {{ $isRtl ? 'تأكيد كلمة المرور' : 'Confirm New Password' }}
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>

                    <button type="submit"
                            class="w-full h-12 bg-primary hover:bg-primary-container text-white font-semibold rounded-lg transition-all active:scale-[0.98] text-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">key</span>
                        {{ $isRtl ? 'تحديث كلمة المرور' : 'Update Password' }}
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
