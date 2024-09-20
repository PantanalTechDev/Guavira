<x-guest-layout>
    <form method="POST" action="{{ route('guavira.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Latitude -->
        <div class="mt-4">
            <x-input-label for="latitude" :value="__('Latitude')" />
            <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude" :value="old('latitude')" required autocomplete="latitude" />
            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
        </div>

        <!-- Longitude -->
        <div class="mt-4">
            <x-input-label for="longitude" :value="__('Longitude')" />
            <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude" :value="old('longitude')" required autocomplete="longitude" />
            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
        </div>

        <!-- Imagem -->
        <div class="mt-4">
            <x-input-label for="imagem" :value="__('Image')" />
            <x-text-input id="imagem" class="block mt-1 w-full" type="file" name="imagem" />
            <x-input-error :messages="$errors->get('imagem')" class="mt-2" />
        </div>

        <!-- Descricao -->
        <div class="mt-4">
            <x-input-label for="descricao" :value="__('Description')" />
            <textarea id="descricao" class="block mt-1 w-full" name="descricao" rows="4" required>{{ old('descricao') }}</textarea>
            <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('guavira.map') }}">
                {{ __('Back to List') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register Guavira') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
