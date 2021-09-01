<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Media Partner') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-jet-form-section submit="">
                <x-slot name="title">
                    {{ __('Media Partner Details') }}
                </x-slot>

                <x-slot name="form">

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="name" value="{{ __('Media Partner Name') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full" autofocus />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>

                </x-slot>

                <x-slot name="actions">
                    <x-jet-button>
                        {{ __('Create') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section>

        </div>
    </div>
</x-app-layout>
