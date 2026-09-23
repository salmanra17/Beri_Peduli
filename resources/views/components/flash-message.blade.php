@props(['class' => ''])

@if (session('success'))
    <div data-flash-message class="{{ $class }} p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
        </svg>
        <p class="text-sm font-semibold">{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div data-flash-message class="{{ $class }} p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center gap-3">
        <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold">{{ session('error') }}</p>
    </div>
@endif

@if ($errors->any())
    <div data-flash-message class="{{ $class }} p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 space-y-1">
        @foreach ($errors->all() as $error)
            <p class="text-sm font-semibold">• {{ $error }}</p>
        @endforeach
    </div>
@endif

@once
    <script>
        (function () {
            document.querySelectorAll('[data-flash-message]').forEach(function (el) {
                setTimeout(function () {
                    el.style.transition = 'opacity 0.5s ease';
                    el.classList.add('opacity-0');
                    setTimeout(function () {
                        el.remove();
                    }, 500);
                }, 4000);
            });
        })();
    </script>
@endonce