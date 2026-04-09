{{--
    Cookie Consent Banner
    Uses Alpine.js + localStorage to remember the user's choice.
    Shows once per browser until accepted or rejected.
--}}
<div
    x-data="cookieBanner()"
    x-show="visible"
    x-cloak
    x-transition:enter="transition duration-300 ease-out"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition duration-200 ease-in"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-0 left-0 right-0 z-[999] px-4 pb-4 pointer-events-none"
    role="dialog"
    aria-live="polite"
    aria-label="Aviso de cookies"
>
    <div class="max-w-4xl mx-auto pointer-events-auto rounded-xl p-5 shadow-2xl"
         style="background:#0d1117; border:1px solid var(--cx-border); box-shadow:0 -4px 40px rgba(0,0,0,.7), 0 0 0 1px rgba(232,57,42,.08)">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            {{-- Icon + text --}}
            <div class="flex items-start gap-4 flex-1 min-w-0">
                <div class="w-9 h-9 rounded-lg flex-shrink-0 flex items-center justify-center mt-0.5"
                     style="background:rgba(232,57,42,.12); border:1px solid rgba(232,57,42,.2)">
                    <i class="fa fa-cookie-bite text-sm" style="color:var(--cx-red)"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-white font-bold text-sm mb-1">
                        <span class="cx-heading">COREX</span><span class="cx-heading" style="color:var(--cx-red)">-DEV</span>
                        {{ __('ui.cookie_uses') }}
                    </p>
                    <p class="text-xs leading-relaxed" style="color:#6b7a90">
                        {{ __('ui.cookie_body') }}
                        <a href="{{ route('legal.privacy') }}" class="underline underline-offset-2 hover:text-white transition-colors" style="color:#8899aa">{{ __('ui.cookie_policy_link') }}</a>
                        {{ __('ui.cookie_and_our') }}
                        <a href="{{ route('legal.terms') }}" class="underline underline-offset-2 hover:text-white transition-colors" style="color:#8899aa">{{ __('ui.cookie_terms_link') }}</a>.
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-2 flex-shrink-0">
                <button
                    @click="reject()"
                    class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all"
                    style="background:transparent; border:1px solid var(--cx-border); color:#4b5568"
                    onmouseenter="this.style.borderColor='rgba(239,68,68,.3)'; this.style.color='#ef4444'"
                    onmouseleave="this.style.borderColor='var(--cx-border)'; this.style.color='#4b5568'">
                    {{ __('ui.cookie_reject') }}
                </button>
                <button
                    @click="accept()"
                    class="px-5 py-2 text-xs font-bold uppercase tracking-wider rounded-lg text-white transition-all"
                    style="background:var(--cx-red); box-shadow:0 0 16px rgba(232,57,42,.3)"
                    onmouseenter="this.style.background='var(--cx-red2)'; this.style.boxShadow='0 0 24px rgba(232,57,42,.5)'"
                    onmouseleave="this.style.background='var(--cx-red)'; this.style.boxShadow='0 0 16px rgba(232,57,42,.3)'">
                    <i class="fa fa-check mr-1.5 text-[10px]"></i>
                    {{ __('ui.cookie_accept') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function cookieBanner() {
        return {
            visible: false,
            init() {
                const consent = localStorage.getItem('cx_cookie_consent');
                if (!consent) {
                    // Small delay so the page finishes loading before the banner appears
                    setTimeout(() => { this.visible = true; }, 800);
                }
            },
            accept() {
                localStorage.setItem('cx_cookie_consent', 'all');
                this.visible = false;
            },
            reject() {
                localStorage.setItem('cx_cookie_consent', 'essential');
                this.visible = false;
            }
        };
    }
</script>
@endpush
