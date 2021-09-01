<div>
   {{-- @if (Gate::check('addTeamMember', $team)) --}}
        <x-jet-section-border />

        <!-- Add Team Member -->
        <div class="mt-10 sm:mt-0">
            <x-jet-form-section submit="addTeamProduct">
                <x-slot name="title">
                    {{ __('Team Products') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Select which products this team has access to.') }}
                </x-slot>

                <x-slot name="form">


                    <div class="col-span-6 lg:col-span-4">
                        <x-jet-label for="products" value="{{ __('Products') }}" />
                        <x-jet-input-error for="products" class="mt-2" />

                        <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                            <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 border-t border-gray-200 rounded-t-none  rounded-b-none"
                                    wire:click="$toggle('addTeamProductsForm.hcp')" >
                                <div class="{{ !isset($addTeamProductsForm['hcp']) || $addTeamProductsForm['hcp'] == 0 ? 'opacity-50' : '' }}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-600 ">
                                            Provider Audience Verification
                                        </div>

                                        @if ($addTeamProductsForm['hcp'] == 1)
                                            <svg class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600">
                                        This product suite helps verify Health Care Provider Activity.
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 border-t border-gray-200 rounded-t-none  rounded-b-none"
                                    wire:click="$toggle('addTeamProductsForm.pav')">
                                <div class="{{ !isset($addTeamProductsForm['pav']) || $addTeamProductsForm['pav'] == 0 ? 'opacity-50' : '' }}">
                                    <!-- Role Name -->
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-600 ">
                                            Patient Audience Verification
                                        </div>

                                        @if ($addTeamProductsForm['pav'] == 1)
                                            <svg class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </div>

                                    <!-- Role Description -->
                                    <div class="mt-2 text-xs text-gray-600">
                                        This product suite helps analyze and predict Patient Audience Activity.
                                    </div>
                                </div>
                            </button>


                        </div>
                    </div>

                </x-slot>
                @if (Gate::check('update', $team))
                    <x-slot name="actions">
                        <x-jet-action-message class="mr-3" on="saved">
                            {{ __('Added.') }}
                        </x-jet-action-message>

                        <x-jet-button>
                            {{ __('Save') }}
                        </x-jet-button>
                    </x-slot>
                @endif

            </x-jet-form-section>
        </div>
    {{-- @endif --}}


</div>
