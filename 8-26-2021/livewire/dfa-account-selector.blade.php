<div>
    {{-- @if (Gate::check('addTeamMember', $team)) --}}
    <x-jet-section-border />

    <!-- Add Team Member -->
    <div class="mt-10 sm:mt-0">
        <x-jet-form-section submit="addDfaAccount">
            <x-slot name="title">
                {{ __('DFA Advertiser') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Select the DFA advertiser to use.  The service account must be added as a user to the profile.') }}
            </x-slot>

            <x-slot name="form">

                <x-form-group name="advertiserId" label="Advertiser" class="col-span-6">
                    <x-custom-select wire:model="advertiserId"
                                     :options="$advertisers"
                                     value-field="id"
                                     text-field="name"
                                     filterable
                                     optional

                    />
                </x-form-group>

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
