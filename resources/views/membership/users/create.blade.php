@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'إضافة مستخدم' : 'Add User' }} — {{ $isRtl ? 'أبو رواش' : 'Ava Rewase' }}</title>
    @include('membership.partials.head-assets')
</head>
<body class="min-h-screen flex flex-col bg-surface-container-low text-on-background antialiased">

    @include('membership.partials.nav')

    <main class="flex-1 flex items-start justify-center p-6">
        <div class="w-full max-w-lg mt-8">
            <div class="mb-6 flex items-center gap-2">
                <a href="{{ route('membership.users.index') }}" class="text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="font-headline text-2xl font-medium text-primary">{{ $isRtl ? 'إضافة مستخدم' : 'Add User' }}</h1>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl login-card-shadow border border-secondary/10">
                <form method="POST" action="{{ route('membership.users.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="name">
                            {{ $isRtl ? 'الاسم' : 'Name' }}
                        </label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" autofocus
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                        @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="email">
                            {{ $isRtl ? 'البريد الإلكتروني' : 'Email Address' }}
                        </label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                        @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="password">
                            {{ $isRtl ? 'كلمة المرور' : 'Password' }}
                        </label>
                        <input id="password" name="password" type="password" autocomplete="new-password"
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                        @error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="password_confirmation">
                            {{ $isRtl ? 'تأكيد كلمة المرور' : 'Confirm Password' }}
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="role">
                            {{ $isRtl ? 'الدور' : 'Role' }}
                        </label>
                        <select id="role" name="role"
                                class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                            <option value="">{{ $isRtl ? '— بدون دور —' : '— No role —' }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                            class="w-full h-12 bg-primary hover:bg-primary-container text-white font-semibold rounded-lg transition-all active:scale-[0.98] text-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">person_add</span>
                        {{ $isRtl ? 'إنشاء المستخدم' : 'Create User' }}
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
