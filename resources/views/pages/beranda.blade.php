@extends('layouts.app')

@section('content')


{{-- ================= HERO ================= --}}

<section class="bg-[#F0F0F0] overflow-hidden">

    <div class="max-w-[1320px] mx-auto px-4 lg:px-10 pt-8 pb-8 lg:pt-10 lg:pb-10">

        <div class="grid lg:grid-cols-2 gap-8 items-center">


            <div>

                <h1 class="text-2xl lg:text-3xl font-bold leading-tight text-neutral-900">
                    {{ __('Ulurkan Tangan Anda,') }}
                    <br>
                    {{ __('Harapan Baru Bagi Mereka') }}
                </h1>


                <p class="mt-3 max-w-lg text-sm text-neutral-600 leading-relaxed">
                    {{ __('Bersama BeriPeduli, kita mempercepat pemulihan bagi mereka yang membutuhkan dengan transparansi penuh dan aksi nyata di lapangan. Jadilah bagian dari perubahan hari ini.') }}
                </p>


                <a href="/kampanye"
                    class="mt-5 inline-flex items-center gap-2
                    rounded-full
                    bg-[#134F4F]
                    px-6 py-2.5
                    text-sm font-semibold
                    text-white shadow-md hover:bg-[#0c4444] transition">

                    {{ __('Donasi Sekarang') }}

                </a>

            </div>



            <div class="relative">


                <img src="{{ asset('images/home/indonesia-map.png') }}"
                    class="absolute inset-0 m-auto w-[600px] opacity-[0.10]"
                    alt="Indonesia Map">


                <div class="relative flex gap-3 h-[300px] lg:h-[340px]">


                    <img src="{{ asset('images/home/hero-main.png') }}"
                        class="w-1/2 h-full rounded-[24px] object-cover shadow-xl">


                    <div class="w-1/2 flex flex-col gap-3">


                        <img src="{{ asset('images/home/hero-side1.png') }}"
                            class="h-1/2 w-full rounded-[20px] object-cover shadow-lg">


                        <img src="{{ asset('images/home/hero-side2.png') }}"
                            class="h-1/2 w-full rounded-[20px] object-cover shadow-lg">


                    </div>


                </div>


            </div>


        </div>

    </div>

</section>




{{-- ================= CAMPAIGN TERBARU ================= --}}

<section class="bg-[#F0F0F0] pt-10 pb-10">


    <div class="max-w-[1320px] mx-auto px-4 lg:px-10">


        <div class="text-center">


            <p class="text-xs font-semibold uppercase tracking-wide text-[#134F4F]">
                {{ __('Kampanye Terbaru') }}
            </p>


            <h2 class="mt-1 text-xl lg:text-2xl font-bold text-neutral-900">
                {{ __('Bantu Mereka Melalui Aksi Nyata') }}
            </h2>


        </div>



        <div class="mt-8 grid md:grid-cols-3 gap-6">


            @foreach($kampanyeAktif as $kampanye)


            <a href="{{ route('kampanye.show',$kampanye->id) }}">


                <article class="bg-white rounded-2xl p-3.5 shadow-sm hover:shadow-lg transition">


                    <div class="relative overflow-hidden rounded-xl">


                        <img src="{{ asset('storage/'.$kampanye->gambar) }}"
                            class="w-full h-40 object-cover"
                            alt="{{ $kampanye->judul_tampil }}">


                        <span class="absolute top-3 left-3
                        bg-[#123F39]
                        text-white text-xs
                        px-3 py-1
                        rounded-full">

                            {{ __('Berlangsung') }}

                        </span>


                    </div>



                    <div class="pt-3">


                        <h3 class="text-sm font-bold text-neutral-900">
                            {{ $kampanye->judul_tampil }}
                        </h3>


                        <p class="mt-1.5 text-xs text-neutral-600">
                            {{ Str::limit($kampanye->deskripsi_tampil, 90) }}
                        </p>



                        <div class="border-t mt-3 pt-3 flex justify-between items-center">


                            <span class="text-xs text-gray-500">
                                {{ __('Donasi Terkumpul') }}
                            </span>


                            <span class="text-sm font-bold text-[#134F4F]">

                                Rp {{ number_format($kampanye->dana_terkumpul,0,',','.') }}

                            </span>


                        </div>


                    </div>


                </article>


            </a>


            @endforeach


        </div>


    </div>


</section>




{{-- ================= CTA ================= --}}

<section class="bg-[#F0F0F0] pt-4 pb-10">

    <div class="max-w-[1320px] mx-auto px-4 lg:px-10">

        <div class="rounded-2xl
            bg-[#134F4F]
            px-6 py-10
            text-center">


            <h2 class="text-xl font-bold text-white">
                {{ __('Siap Menjadi Pahlawan?') }}
            </h2>


            <p class="mt-3 text-sm text-white/80">
                {{ __('Sekecil apapun kontribusi Anda, itu sangat berarti bagi mereka yang membutuhkan.') }}
            </p>



            <a href="/kampanye"
                class="inline-flex mt-6
                rounded-lg
                bg-[#D7A31B]
                px-6 py-2.5
                text-sm font-semibold
                text-white hover:bg-[#c49316] transition">

                {{ __('Donasi Sekarang') }}

            </a>



            <p class="mt-4 text-xs text-white/80">
                {{ __('Bergabung dengan 2.5k+ donatur minggu ini') }}
            </p>



        </div>

    </div>

</section>


@endsection