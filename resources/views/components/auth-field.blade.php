@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'autocomplete' => null,
    'autofocus' => false,
    'required' => false,
    'viewable' => false,
])

<div>
    <label for="{{ $name }}" class="mb-2 block text-sm font-semibold text-[#111827]">
        {{ $label }}
    </label>

    <div class="relative">
        @if ($icon ?? '')
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#105b59]">
                {{ $icon }}
            </span>
        @endif

        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $type === 'password' ? '' : old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($autofocus) autofocus @endif
            @if ($required) required @endif
            @class([
                'w-full rounded-xl border-2 border-[#105b59] bg-[#d8efeb] py-3.5 text-[#111827] transition placeholder-[#5d918a]',
                'focus:border-[#0c4a3d] focus:outline-none',
                'pl-12' => $icon ?? '',
                'pl-4' => ! ($icon ?? ''),
                'pr-12' => $viewable,
                'pr-4' => ! $viewable,
            ])
        />

        @if ($viewable)
            <button
                type="button"
                data-password-toggle="{{ $name }}"
                tabindex="-1"
                aria-label="{{ __('Tampilkan kata sandi') }}"
                class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#105b59] transition hover:text-[#0c4a3d]"
            >
                <svg data-icon="eye" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <svg data-icon="eye-slash" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </button>
        @endif
    </div>

    @error($name)
        <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror
</div>