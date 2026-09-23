@extends('layouts.admin')

@section('content')

<div class="min-h-[80vh] flex items-center justify-center py-10 px-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[85vh] overflow-y-auto p-8">

        {{-- JUDUL --}}

        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Verifikasi Kampanye</p>
        <h1 class="mt-2 text-xl font-bold text-neutral-900">{{ $kampanye->judul }}</h1>
        <p class="mt-1 text-sm text-gray-500">Diajukan oleh {{ $kampanye->user->name }}</p>

        <x-flash-message class="mt-4" />

        {{-- INFO KAMPANYE --}}

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
            <div>
                <p class="text-xs font-semibold text-gray-400">Kategori</p>
                <p class="mt-1 text-gray-900">{{ $kampanye->kategori }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400">Target Dana</p>
                <p class="mt-1 text-gray-900">Rp {{ number_format($kampanye->target_dana, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400">Batas Waktu</p>
                <p class="mt-1 text-gray-900">{{ $kampanye->batas_tanggal->translatedFormat('d F Y') }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400">NIK</p>
                <p class="mt-1 text-gray-900">{{ $kampanye->nik ?? '-' }}</p>
            </div>
        </div>

        {{-- DESKRIPSI --}}

        <div class="mt-4">
            <p class="text-xs font-semibold text-gray-400">Deskripsi</p>
            <p class="mt-1 text-sm leading-relaxed text-gray-700">{{ $kampanye->deskripsi }}</p>
        </div>

        {{-- FOTO VERIFIKASI --}}

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400">Foto KTP</p>
                @if ($kampanye->foto_ktp)
                    <img src="{{ asset('storage/' . $kampanye->foto_ktp) }}" alt="Foto KTP"
                         class="mt-2 w-full aspect-[4/3] object-cover rounded-xl bg-gray-100">
                @else
                    <div class="mt-2 w-full aspect-[4/3] flex items-center justify-center rounded-xl bg-gray-100 border border-dashed border-gray-200">
                        <p class="text-xs text-gray-400">Belum diunggah</p>
                    </div>
                @endif
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-400">Foto Diri</p>
                @if ($kampanye->foto_diri)
                    <img src="{{ asset('storage/' . $kampanye->foto_diri) }}" alt="Foto Diri"
                         class="mt-2 w-full aspect-[4/3] object-cover rounded-xl bg-gray-100">
                @else
                    <div class="mt-2 w-full aspect-[4/3] flex items-center justify-center rounded-xl bg-gray-100 border border-dashed border-gray-200">
                        <p class="text-xs text-gray-400">Belum diunggah</p>
                    </div>
                @endif
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-400">Foto Pegang KTP</p>
                @if ($kampanye->foto_memegang_ktp)
                    <img src="{{ asset('storage/' . $kampanye->foto_memegang_ktp) }}" alt="Foto Pegang KTP"
                         class="mt-2 w-full aspect-[4/3] object-cover rounded-xl bg-gray-100">
                @else
                    <div class="mt-2 w-full aspect-[4/3] flex items-center justify-center rounded-xl bg-gray-100 border border-dashed border-gray-200">
                        <p class="text-xs text-gray-400">Belum diunggah</p>
                    </div>
                @endif
            </div>

            <div class="rounded-xl bg-gray-50 border border-gray-100 p-4 flex flex-col justify-center">
                <p class="text-xs font-semibold text-gray-400">Rekening Penyaluran</p>
                <p class="mt-2 text-sm font-semibold text-gray-900">{{ $kampanye->bank_penyaluran ?? '-' }}</p>
                <p class="mt-1 text-sm text-gray-600">{{ $kampanye->nomor_rekening ?? '-' }}</p>
            </div>
        </div>

        {{-- AKSI VERIFIKASI --}}

        @if ($kampanye->status === 'menunggu')
            <div class="mt-8 flex gap-4">
                <form action="{{ route('admin.kampanye.reject', $kampanye->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" onclick="return confirm('Yakin ingin menolak kampanye ini?')"
                            class="w-full rounded-xl border border-red-200 py-3 font-semibold text-red-600 transition hover:bg-red-50">
                        Tolak
                    </button>
                </form>

                <form action="{{ route('admin.kampanye.approve', $kampanye->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="w-full rounded-xl bg-[#134F4F] py-3 font-semibold text-white transition hover:bg-[#0c4444]">
                        Terima
                    </button>
                </form>
            </div>
        @endif

        <a href="{{ route('admin.kampanye.index', ['status' => $kampanye->status]) }}"
           class="inline-block mt-6 text-sm text-[#134F4F] font-semibold hover:underline">
            &larr; Kembali ke daftar
        </a>

    </div>

</div>

@endsection