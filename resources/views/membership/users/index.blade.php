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
            @elseif(session('status') === 'mfa-reset')
            <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                {{ $isRtl ? 'تمت إعادة تعيين المصادقة الثنائية بنجاح.' : 'MFA reset successfully.' }}
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
                                <div class="flex items-center justify-end gap-3">
                                    @if($u->mfa_enabled)
                                    <button type="button"
                                            class="mfa-reset-trigger inline-flex items-center gap-1 text-red-600 hover:text-red-700 transition-colors text-xs font-semibold"
                                            data-reset-url="{{ route('membership.users.mfa.reset', $u) }}"
                                            data-user-name="{{ $u->name }}">
                                        <span class="material-symbols-outlined text-sm">lock_reset</span>
                                        {{ $isRtl ? 'إعادة تعيين المصادقة الثنائية' : 'Reset MFA' }}
                                    </button>
                                    @endif
                                    <a href="{{ route('membership.users.edit', $u) }}"
                                       class="inline-flex items-center gap-1 text-primary hover:text-secondary transition-colors text-xs font-semibold">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                        {{ $isRtl ? 'تعديل' : 'Edit' }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </main>

    <div id="mfa-reset-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="bg-surface-container-lowest rounded-xl login-card-shadow border border-secondary/10 max-w-sm w-full p-6">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined">lock_reset</span>
                </div>
                <h2 class="font-headline text-lg font-medium text-on-background">
                    {{ $isRtl ? 'إعادة تعيين المصادقة الثنائية' : 'Reset MFA' }}
                </h2>
            </div>
            <p class="text-on-surface-variant text-sm mb-5">
                {{ $isRtl ? 'أنت على وشك إعادة تعيين المصادقة الثنائية للمستخدم' : 'You are about to reset MFA for' }}
                <span id="mfa-reset-modal-user" class="font-semibold text-on-background"></span>.
                {{ $isRtl ? 'اضغط مع الاستمرار على الزر أدناه لمدة 10 ثوانٍ للتأكيد.' : 'Press and hold the button below for 10 seconds to confirm.' }}
            </p>

            <form id="mfa-reset-modal-form" method="POST" action="">
                @csrf
                <button type="button"
                        class="hold-confirm-btn relative overflow-hidden w-full inline-flex items-center justify-center gap-1 text-red-600 hover:text-red-700 transition-colors text-sm font-semibold px-4 py-3 rounded-lg border border-red-200"
                        data-hold-ms="10000"
                        data-label-idle="{{ $isRtl ? 'اضغط مع الاستمرار للتأكيد' : 'Press and hold to confirm' }}"
                        data-label-holding="{{ $isRtl ? 'استمر بالضغط… ' : 'Keep holding… ' }}">
                    <span class="hold-confirm-progress absolute inset-0 bg-red-100" style="width:0%"></span>
                    <span class="hold-confirm-content relative inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">lock_reset</span>
                        <span class="hold-confirm-text">{{ $isRtl ? 'اضغط مع الاستمرار للتأكيد' : 'Press and hold to confirm' }}</span>
                    </span>
                </button>
            </form>

            <button type="button" id="mfa-reset-modal-cancel"
                    class="mt-3 w-full text-center text-on-surface-variant hover:text-on-background text-sm font-medium py-2">
                {{ $isRtl ? 'إلغاء' : 'Cancel' }}
            </button>
        </div>
    </div>

    <script>
        function initHoldConfirm(btn) {
            const form = btn.closest('form');
            const progress = btn.querySelector('.hold-confirm-progress');
            const text = btn.querySelector('.hold-confirm-text');
            const holdMs = parseInt(btn.dataset.holdMs, 10) || 10000;
            const labelIdle = btn.dataset.labelIdle;
            const labelHolding = btn.dataset.labelHolding;

            let startTime = null;
            let rafId = null;
            let pressing = false;

            function tick() {
                const elapsed = Date.now() - startTime;
                const pct = Math.min(100, (elapsed / holdMs) * 100);
                progress.style.width = pct + '%';
                text.textContent = labelHolding + Math.ceil((holdMs - elapsed) / 1000) + 's';

                if (elapsed >= holdMs) {
                    text.textContent = labelIdle;
                    progress.style.width = '0%';
                    pressing = false;
                    form.submit();
                    return;
                }

                if (pressing) {
                    rafId = requestAnimationFrame(tick);
                }
            }

            function start(e) {
                e.preventDefault();
                if (pressing) return;
                pressing = true;
                startTime = Date.now();
                rafId = requestAnimationFrame(tick);
            }

            function cancel() {
                if (!pressing) return;
                pressing = false;
                cancelAnimationFrame(rafId);
                progress.style.width = '0%';
                text.textContent = labelIdle;
            }

            btn.addEventListener('mousedown', start);
            btn.addEventListener('touchstart', start, { passive: false });
            btn.addEventListener('mouseup', cancel);
            btn.addEventListener('mouseleave', cancel);
            btn.addEventListener('touchend', cancel);
            btn.addEventListener('touchcancel', cancel);
        }

        const mfaModal = document.getElementById('mfa-reset-modal');
        const mfaModalForm = document.getElementById('mfa-reset-modal-form');
        const mfaModalUser = document.getElementById('mfa-reset-modal-user');
        const mfaModalCancel = document.getElementById('mfa-reset-modal-cancel');
        const mfaModalHoldBtn = mfaModalForm.querySelector('.hold-confirm-btn');

        initHoldConfirm(mfaModalHoldBtn);

        function openMfaModal(url, userName) {
            mfaModalForm.action = url;
            mfaModalUser.textContent = userName;
            mfaModal.classList.remove('hidden');
            mfaModal.classList.add('flex');
        }

        function closeMfaModal() {
            mfaModal.classList.add('hidden');
            mfaModal.classList.remove('flex');
            mfaModalHoldBtn.dispatchEvent(new Event('mouseleave'));
        }

        document.querySelectorAll('.mfa-reset-trigger').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                openMfaModal(trigger.dataset.resetUrl, trigger.dataset.userName);
            });
        });

        mfaModalCancel.addEventListener('click', closeMfaModal);
        mfaModal.addEventListener('click', function (e) {
            if (e.target === mfaModal) closeMfaModal();
        });
    </script>
</body>
</html>
