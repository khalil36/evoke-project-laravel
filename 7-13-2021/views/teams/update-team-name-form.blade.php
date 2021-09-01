<x-jet-form-section submit="updateTeamName">
    <x-slot name="title">
        {{ __('Team Name') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The team\'s name and owner information.') }}
    </x-slot>

    <x-slot name="form">
    {{--<!-- Team Owner Information -->
    <div class="col-span-6">
        <x-jet-label value="{{ __('Team Owner') }}" />

        <div class="flex items-center mt-2">
            <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}" alt="{{ $team->owner->name }}">

            <div class="ml-4 leading-tight">
                <div>{{ $team->owner->name }}</div>
                <div class="text-gray-700 text-sm">{{ $team->owner->email }}</div>
            </div>
        </div>
    </div>--}}

    <!-- Team Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Team Name') }}"/>

            <x-jet-input id="name"
                         type="text"
                         class="mt-1 block w-full"
                         wire:model.defer="state.name"
                         :disabled="! Gate::check('update', $team)"/>

            <x-jet-input-error for="name" class="mt-2"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="website" value="{{ __('Website') }}"/>

            <x-jet-input id="website"
                         type="text"
                         class="mt-1 block w-full"
                         wire:model.defer="state.website"
                         :disabled="! Gate::check('update', $team)"/>

            <x-jet-input-error for="website" class="mt-2"/>
        </div>
        <div class="col-span-6 sm:col-span-4">

            <div class="flex items-center justify-between">
                <span class="flex-grow flex flex-col" id="availability-label">
                    <span class="text-sm font-medium text-gray-900">Status</span>
                    @if (Gate::check('update', $team))
                        <span class="text-sm text-gray-500">Activate this team.  Only evoke admins/users can access teams that are not active.</span>
                    @endif
                </span>

                <x-switch-toggle wire:model="state.is_active" class="active:text-evoke" :disabled="! Gate::check('update', $team)" />

            </div>
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    @endif
</x-jet-form-section>

