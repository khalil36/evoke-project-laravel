<x-jet-form-section submit="parseImport">
    <x-slot name="title">
        {{ __(' Import NPIs') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Import NPIs from csv or xlsx file.') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="csv_file" value="{{ __('CSV or XLSX') }}" class="space-y-6 block" /><br>
            <!-- <input id="csv_file" type="file" class="mt-1 block w-full" wire:model="csv_file"  /> -->
            <input type="file" wire:model="csv_file" class="space-y-6 block">
            <x-jet-input-error for="csv_file" class="mt-2" />

            <br>
            <a href="{{ asset('uploads/files/NPIS-example-file.csv') }}" class="no-underline hover:underline text-blue-700">Download example file</a>
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-button>
            {{ __('Map File') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

