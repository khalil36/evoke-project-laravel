<x-jet-form-section submit="myCreateTeam">
    <x-slot name="title">
        {{ __('Team Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create a new team to collaborate with others on projects.') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Team Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autofocus />
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="website" value="{{ __('Website') }}" />
            <x-jet-input id="website" type="text" class="mt-1 block w-full" wire:model.defer="state.website" autofocus />
            <x-jet-input-error for="website" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
                <div class="flex items-center justify-between">
                <span class="flex-grow flex flex-col" id="availability-label">
                    <span class="text-sm font-medium text-gray-900">Status</span>
                    <span class="text-sm text-gray-500">Activate this team.  Only evoke admins/users can access teams that are not active.</span>
                </span>
                    <x-switch-toggle wire:model="state.is_active" class="active:text-evoke" />
                </div>

        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-button>
            {{ __('Create') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
