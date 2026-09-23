@extends('layouts.app')

@section('content')

<main class="bg-[#f1f1f1]">


    {{-- ================= HERO ================= --}}

    <section class="flex min-h-[calc(100vh-64px)] flex-col justify-center items-center bg-[#f1f1f1] px-4 py-12 text-center lg:px-10">

        <div class="mx-auto max-w-[680px]">

            <span class="inline-block rounded-full bg-[#fbbd32] px-4 py-1 text-[11px] font-bold tracking-wider text-[#105b59] shadow-sm">
                {{ __('MISI KEMANUSIAAN') }}
            </span>

            <h1 class="mt-4 text-2xl font-bold text-[#105b59] sm:text-3xl lg:text-4xl">
                {{ __('Tentang BeriPeduli') }}
            </h1>

            <p class="mx-auto mt-3 max-w-[560px] text-sm leading-relaxed text-gray-600">
                {{ __('Kami hadir untuk menjembatani kepedulian Anda dengan mereka yang membutuhkan, mulai dari bantuan medis, pendidikan, hingga kesejahteraan sosial. Melalui platform yang transparan, cepat, dan terpercaya, setiap bantuan Anda menjadi pilar kebangkitan bagi sesama.') }}
            </p>

            <div class="mt-6">
                <a href="#visi-misi" id="learn-more-button"
                    class="inline-flex items-center gap-2 rounded-full
                    bg-[#105b59] px-6 py-2.5 text-sm font-semibold text-white shadow-md
                    transition hover:bg-[#0c4a3d] hover:shadow-lg active:scale-95">
                    {{ __('Pelajari Lebih Lanjut') }}

                    <svg class="h-3.5 w-3.5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                    </svg>
                </a>
            </div>

        </div>

    </section>




    {{-- ================= VISI & MISI ================= --}}

    <section id="visi-misi" class="scroll-mt-16 bg-white py-10 lg:py-14">

        <div class="mx-auto max-w-[1320px] px-4 lg:px-10">

            <div class="grid gap-5 md:grid-cols-2">

                {{-- VISI --}}
                <article class="flex flex-col justify-between rounded-2xl bg-[#105b59] p-6 text-white shadow-md transition hover:shadow-lg">

                    <div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-[#fbbd32]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-lg font-bold">
                            {{ __('Visi Kami') }}
                        </h3>

                        <p class="mt-2 text-sm leading-relaxed text-white/90">
                            {{ __('Menjadi platform kemanusiaan digital terdepan di Indonesia yang memastikan setiap individu yang membutuhkan mendapatkan uluran tangan, membangun masyarakat yang peduli, tangguh, dan saling berempati.') }}
                        </p>
                    </div>

                </article>

                {{-- MISI --}}
                <article class="flex flex-col justify-between rounded-2xl bg-[#105b59] p-6 text-white shadow-md transition hover:shadow-lg">

                    <div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-[#fbbd32]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-lg font-bold">
                            {{ __('Misi Kami') }}
                        </h3>

                        <ul class="mt-2 flex flex-col gap-2.5 text-sm leading-relaxed text-white/90">

                            <li class="flex gap-2.5">
                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#fbbd32]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span>{{ __('Menyediakan akses donasi yang cepat, aman, dan 100% transparan.') }}</span>
                            </li>

                            <li class="flex gap-2.5">
                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#fbbd32]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span>{{ __('Berkolaborasi dengan lembaga kemanusiaan terpercaya untuk distribusi bantuan yang efektif.') }}</span>
                            </li>

                            <li class="flex gap-2.5">
                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#fbbd32]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span>{{ __('Meningkatkan kesadaran masyarakat akan pentingnya gotong royong dalam berbagai aksi kemanusiaan dan sosial.') }}</span>
                            </li>

                        </ul>
                    </div>

                </article>

            </div>

        </div>

    </section>




    {{-- ================= NILAI INTI ================= --}}

    <section class="bg-[#f1f1f1] py-8 lg:py-10">

        <div class="mx-auto max-w-[1320px] px-4 text-center lg:px-10">

            <h2 class="text-lg lg:text-xl font-bold text-gray-800">
                {{ __('Nilai Inti Kami') }}
            </h2>

            <p class="mx-auto mt-1 max-w-md text-xs sm:text-sm text-gray-500">
                {{ __('Prinsip yang membimbing setiap langkah kami dalam menyampaikan amanah Anda.') }}
            </p>

            <div class="mt-6 grid gap-4 md:grid-cols-3">

                {{-- TRANSPARANSI --}}
                <article class="rounded-xl bg-white p-4 sm:p-5 shadow-xs border border-gray-100 transition hover:shadow-sm">

                    <div class="mx-auto flex h-9 w-9 items-center justify-center rounded-lg bg-[#105b59]/10 text-[#105b59]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <h3 class="mt-3 text-sm font-semibold text-gray-800">
                        {{ __('Transparansi') }}
                    </h3>

                    <p class="mt-1 text-xs leading-relaxed text-gray-500">
                        {{ __('Laporan donasi dan penyaluran dana yang dapat diakses secara real-time oleh publik.') }}
                    </p>

                </article>

                {{-- KECEPATAN --}}
                <article class="rounded-xl bg-white p-4 sm:p-5 shadow-xs border border-gray-100 transition hover:shadow-sm">

                    <div class="mx-auto flex h-9 w-9 items-center justify-center rounded-lg bg-[#105b59]/10 text-[#105b59]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>

                    <h3 class="mt-3 text-sm font-semibold text-gray-800">
                        {{ __('Kecepatan') }}
                    </h3>

                    <p class="mt-1 text-xs leading-relaxed text-gray-500">
                        {{ __('Respon cepat dalam mengumpulkan dan mendistribusikan bantuan kepada mereka yang membutuhkan sesegera mungkin.') }}
                    </p>

                </article>

                {{-- KEPEDULIAN --}}
                <article class="rounded-xl bg-white p-4 sm:p-5 shadow-xs border border-gray-100 transition hover:shadow-sm">

                    <div class="mx-auto flex h-9 w-9 items-center justify-center rounded-lg bg-[#105b59]/10 text-[#105b59]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </div>

                    <h3 class="mt-3 text-sm font-semibold text-gray-800">
                        {{ __('Kepedulian') }}
                    </h3>

                    <p class="mt-1 text-xs leading-relaxed text-gray-500">
                        {{ __('Menempatkan empati dan kemanusiaan di atas segalanya dalam setiap interaksi.') }}
                    </p>

                </article>

            </div>

        </div>

    </section>




    {{-- ================= CTA ================= --}}

    <section class="bg-[#f1f1f1] pb-10 lg:pb-12">

        <div class="mx-auto max-w-[1320px] px-4 lg:px-10">

            <div class="rounded-xl bg-white px-5 py-7 text-center shadow-xs border border-gray-100 lg:px-8 lg:py-8">

                <h2 class="text-base sm:text-lg font-bold text-gray-800">
                    {{ __('Mari Menjadi Bagian dari Solusi') }}
                </h2>

                <p class="mx-auto mt-1.5 max-w-lg text-xs leading-relaxed text-gray-500">
                    {{ __('Kebaikan kecil Anda dapat menjadi harapan besar bagi mereka. Bergabunglah bersama ribuan donatur lainnya atau mulai galang dana untuk daerah yang membutuhkan.') }}
                </p>

                <div class="mt-5 flex flex-col items-center justify-center gap-2.5 sm:flex-row">

                    <a href="{{ route('kampanye.index') }}"
                        class="inline-flex items-center rounded-lg
                        bg-[#105b59] px-4 py-2 text-xs font-semibold text-white shadow-xs
                        transition hover:bg-[#0c4a3d]">
                        {{ __('Donasi Sekarang') }}
                    </a>

                    <a href="{{ route('kampanye.create') }}"
                        class="inline-flex items-center rounded-lg
                        border border-[#105b59] bg-white px-4 py-2 text-xs font-semibold text-[#105b59]
                        transition hover:bg-gray-50">
                        {{ __('Mulai Galang Dana') }}
                    </a>

                </div>

            </div>

        </div>

    </section>



</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('learn-more-button');
        const target = document.getElementById('visi-misi');

        if (button && target) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const navbar = document.querySelector('nav');
                const navHeight = navbar ? navbar.offsetHeight : 60;
                const startY = window.scrollY;
                const targetY = target.getBoundingClientRect().top + window.scrollY - navHeight;
                const distance = targetY - startY;
                const duration = 800;
                const startTime = performance.now();

                function easeInOutCubic(t) {
                    return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
                }

                function step(now) {
                    const progress = Math.min((now - startTime) / duration, 1);
                    window.scrollTo(0, startY + distance * easeInOutCubic(progress));

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                }

                requestAnimationFrame(step);
            });
        }
    });
</script>

@endsection