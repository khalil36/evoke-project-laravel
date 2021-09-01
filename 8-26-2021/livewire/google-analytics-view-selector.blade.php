<div>
    {{-- @if (Gate::check('addTeamMember', $team)) --}}
    <x-jet-section-border />

    <!-- Add Team Member -->
    <div class="mt-10 sm:mt-0">
        <x-jet-form-section submit="addGAView">
            <x-slot name="title">
                {{ __('Google Analytics Profile') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Select the google analytics profile to use.  The service account must be added as a user to the profile.') }}
            </x-slot>

            <x-slot name="form">

                <x-form-group name="accountId" label="Account" class="col-span-6">
                    <x-custom-select wire:model="accountId"
                                     :options="$accounts"
                                     value-field="id"
                                     text-field="name"
                                     optional

                    />
                </x-form-group>

                @if (!is_null($accountId))
                <x-form-group name="propertyId" label="Property" class="col-span-6">
                    <x-custom-select wire:model="propertyId"
                                     :options="$properties"
                                     value-field="id"
                                     text-field="name"
                                     optional
                                     :wire-listeners="['property-updated']"
                    />
                </x-form-group>
                @endif

                @if (!is_null($propertyId))
                <x-form-group name="viewId" label="View" class="col-span-6">
                    <x-custom-select wire:model="viewId"
                                     :options="$views"
                                     value-field="id"
                                     text-field="name"
                                     optional
                                     :wire-listeners="['view-updated']"
                    />
                </x-form-group>
                @endif



            </x-slot>
            @if (Gate::check('update', $team))
                <x-slot name="actions">
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-jet-action-message>

                    @if($isDisabled)
                        <x-jet-button>
                        {{ __('Save') }}
                        </x-jet-button>
                    @else
                        <x-jet-button disabled="disabled">
                            {{ __('Save') }}
                        </x-jet-button>
                    @endif
                </x-slot>
            @endif

        </x-jet-form-section>
    </div>
    {{-- @endif --}}


</div>
