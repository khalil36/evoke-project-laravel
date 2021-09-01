<div class="">
    <div class="">
        <div class="text-left">
        <div class="" >
            <x-jet-secondary-button wire:click="confirmMediaPartnerDeletion" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-secondary-button>
        </div>

        <!-- Delete Media Partner Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingMediaPartnerDeletion">
            <x-slot name="title">
                {{ __('Delete Media Partner') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete the media partner "'.$mediaPartner['media_partner_name'].'"?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingMediaPartnerDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteMediaPartner({{$mediaPartner['media_partner_id']}})" wire:loading.attr="disabled">
                    {{ __('Delete Media Partner') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>


        </div>
    </div>
</div>
