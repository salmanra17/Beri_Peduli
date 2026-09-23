@extends('layouts.admin')

@section('content')

<div class="w-full max-w-[1320px] mx-auto px-6 lg:px-10 py-10">

    {{-- HEADER --}}

    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-neutral-900">Manajemen User</h1>
        <p class="mt-1.5 text-sm text-gray-500">
            @if ($role && $role !== 'semua')
                {{ $users->total() }} user berperan {{ $role }}
            @else
                {{ $users->total() }} user terdaftar
            @endif
        </p>
    </div>

    {{-- FLASH MESSAGE --}}

    <x-flash-message class="mt-6 mb-4" />

    {{-- SEARCH --}}

    <form method="GET" action="{{ route('admin.user.index') }}" class="mt-6 flex gap-3">
        <input type="hidden" name="role" value="{{ $role }}">
        <div class="relative flex-1 max-w-md">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
            </span>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari nama atau email user..."
                   class="w-full h-[46px] pl-10 pr-4 rounded-xl bg-white border border-gray-200 text-sm focus:ring-2 focus:ring-[#134F4F] focus:border-[#134F4F] focus:outline-none">
        </div>
        <button type="submit" class="h-[46px] px-6 rounded-xl bg-[#134F4F] hover:bg-[#0c4444] text-white text-sm font-semibold transition-colors">
            Cari
        </button>
    </form>

    {{-- TAB BAR --}}

    @php
        $tabParams = fn ($r) => array_filter(['role' => $r, 'q' => request('q')]);
    @endphp

    <div class="mt-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.user.index', $tabParams(null)) }}"
           class="{{ $role === null ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[132px] py-2 rounded-full text-sm font-semibold transition">
            Semua ({{ $countSemua }})
        </a>
        <a href="{{ route('admin.user.index', $tabParams('penggalang')) }}"
           class="{{ $role === 'penggalang' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[132px] py-2 rounded-full text-sm font-semibold transition">
            Penggalang ({{ $countPenggalang }})
        </a>
        <a href="{{ route('admin.user.index', $tabParams('donatur')) }}"
           class="{{ $role === 'donatur' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[132px] py-2 rounded-full text-sm font-semibold transition">
            Donatur ({{ $countDonatur }})
        </a>
        <a href="{{ route('admin.user.index', $tabParams('admin')) }}"
           class="{{ $role === 'admin' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[132px] py-2 rounded-full text-sm font-semibold transition">
            Admin ({{ $countAdmin }})
        </a>
    </div>

    {{-- TABEL --}}

    @php
        $roleBadges = [
            'admin' => ['bg-amber-50', 'text-amber-600', 'border-amber-200/60'],
            'penggalang' => ['bg-teal-50', 'text-teal-600', 'border-teal-200/60'],
            'donatur' => ['bg-emerald-50', 'text-emerald-600', 'border-emerald-200/60'],
        ];
    @endphp

    <div class="mt-6 w-full bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left table-fixed">
            <thead>
                <tr class="border-b border-gray-100 bg-[#FAFAFA]">
                    <th class="w-[26%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Nama</th>
                    <th class="w-[24%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Email</th>
                    <th class="w-[12%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Role</th>
                    <th class="w-[14%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Bergabung</th>
                    <th class="w-[12%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Status</th>
                    <th class="w-[12%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-[#FAFFF9]/40 transition-colors">
                        <td class="px-6 py-4 min-w-0">
                            <p class="font-semibold text-gray-900 truncate" title="{{ $user->name }}">{{ $user->name }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 truncate" title="{{ $user->email }}">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold border
                                {{ $roleBadges[$user->role][0] }} {{ $roleBadges[$user->role][1] }} {{ $roleBadges[$user->role][2] }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if ($user->is_active)
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200/60">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold bg-red-50 text-red-600 border border-red-200/60">
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex items-center gap-2">
                                <button type="button"
                                        onclick="document.getElementById('modal-user-{{ $user->id }}').classList.remove('hidden'); document.getElementById('modal-user-{{ $user->id }}').classList.add('flex');"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-200 p-2 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </button>

                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.user.toggle-status', $user->id) }}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('PATCH')
                                        @if ($user->is_active)
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin menonaktifkan akun ini?')"
                                                    aria-label="Nonaktifkan akun"
                                                    class="inline-flex items-center justify-center rounded-lg border border-red-200 p-2 text-red-600 transition hover:bg-red-50 cursor-pointer">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M18.364 18.364A9 9 0 1 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin mengaktifkan kembali akun ini?')"
                                                    aria-label="Aktifkan kembali akun"
                                                    class="inline-flex items-center justify-center rounded-lg border border-emerald-200 p-2 text-emerald-600 transition hover:bg-emerald-50 cursor-pointer">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                            @if ($q)
                                Tidak ada user yang cocok dengan pencarian "{{ $q }}".
                                <a href="{{ route('admin.user.index', $role ? ['role' => $role] : []) }}" class="text-[#134F4F] hover:underline font-semibold">Reset pencarian</a>
                            @else
                                Tidak ada user di kategori ini.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer tabel: info + pagination --}}
        @if ($users->total() > 0)
            <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">

                <p class="text-sm text-gray-400">
                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
                </p>

                {{-- Pagination custom --}}
                <div class="flex items-center gap-1">

                    {{-- Prev --}}
                    @if ($users->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Halaman --}}
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if ($page === $users->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#134F4F] text-white text-sm font-bold">
                                {{ $page }}
                            </span>
                        @elseif ($page === 1 || $page === $users->lastPage() || abs($page - $users->currentPage()) <= 1)
                            <a href="{{ $url }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                                {{ $page }}
                            </a>
                        @elseif (abs($page - $users->currentPage()) === 2)
                            <span class="w-8 h-8 flex items-center justify-center text-sm text-gray-400">…</span>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                            </svg>
                        </a>
                    @else
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                            </svg>
                        </span>
                    @endif

                </div>

            </div>
        @endif
    </div>

    {{-- ============ MODAL DETAIL USER ============ --}}

    @foreach ($users as $user)
        <div id="modal-user-{{ $user->id }}"
             class="fixed inset-0 z-[999] hidden items-center justify-center p-4"
             role="dialog" aria-modal="true">

            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                 onclick="document.getElementById('modal-user-{{ $user->id }}').classList.add('hidden'); document.getElementById('modal-user-{{ $user->id }}').classList.remove('flex');"></div>

            {{-- Card --}}
            <div class="relative bg-white w-full max-w-2xl max-h-[85vh] overflow-y-auto rounded-2xl shadow-xl z-10 p-8">

                {{-- Tombol tutup --}}
                <button type="button"
                        onclick="document.getElementById('modal-user-{{ $user->id }}').classList.add('hidden'); document.getElementById('modal-user-{{ $user->id }}').classList.remove('flex');"
                        aria-label="Tutup"
                        class="absolute top-4 right-4 rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Judul --}}
                <div class="flex items-center gap-4">
                    @if ($user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}"
                             class="w-16 h-16 rounded-full object-cover border-2 border-gray-100 flex-shrink-0">
                    @else
                        <div class="w-16 h-16 rounded-full bg-[#134F4F] text-white flex items-center justify-center font-bold text-lg flex-shrink-0">
                            {{ strtoupper($user->initials()) }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Detail User</p>
                        <h2 class="mt-1 text-xl font-bold text-neutral-900 truncate">{{ $user->name }}</h2>
                    </div>
                </div>

                {{-- Info user --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Nama Depan</p>
                        <p class="mt-1 text-gray-900">{{ $user->resolved_nama_depan }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Nama Belakang</p>
                        <p class="mt-1 text-gray-900">{{ $user->resolved_nama_belakang }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Email</p>
                        <p class="mt-1 text-gray-900 break-all">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Role</p>
                        <p class="mt-1 text-gray-900 capitalize">{{ $user->role }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">No. HP</p>
                        <p class="mt-1 text-gray-900">{{ $user->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Tanggal Lahir</p>
                        <p class="mt-1 text-gray-900">{{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d M Y') : '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-gray-400">Alamat</p>
                        <p class="mt-1 text-gray-900">{{ $user->alamat ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Provinsi</p>
                        <p class="mt-1 text-gray-900">{{ $user->provinsi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Kota / Kabupaten</p>
                        <p class="mt-1 text-gray-900">{{ $user->kota ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Kode Pos</p>
                        <p class="mt-1 text-gray-900">{{ $user->kode_pos ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Tanggal Bergabung</p>
                        <p class="mt-1 text-gray-900">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>

            </div>
        </div>
    @endforeach

    {{-- Tutup modal saat tombol Escape ditekan --}}
    <script>
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal-user-"]').forEach(function (m) {
                    if (!m.classList.contains('hidden')) {
                        m.classList.add('hidden');
                        m.classList.remove('flex');
                    }
                });
            }
        });
    </script>

</div>

@endsection