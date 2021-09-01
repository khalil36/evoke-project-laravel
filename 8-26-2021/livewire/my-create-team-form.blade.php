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
            <x-jet-label for="flight_start_date" value="{{ __('Flight Start Date') }}" />
            <!-- <x-date-picker id="flight_start_date_in_create_page" class="flight_start_date" wire:model.defer="state.flight_start_date" :options="[ 'clickOpens' => true, 'allowInput' => true ]" /> -->
            <div class="form-text-container flex rounded-sm shadow-sm relative">
                <span class="leading-addon cursor-pointer inline-flex items-center px-3 rounded-l-md border border-r-0 border-blue-gray-300 bg-blue-gray-50 text-blue-gray-500 sm:text-sm" title="Select a date">
                    <span class="h-5 w-5 text-blue-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>            
                    </span>
                </span>

                <input class="form-input form-text flex-1 block w-full" placeholder="Y-m-d" type="text" id="flight_start_date_in_create_page"  wire:model.defer="state.flight_start_date">

            </div>
            <x-jet-input-error for="flight_start_date" class="mt-2" />
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
