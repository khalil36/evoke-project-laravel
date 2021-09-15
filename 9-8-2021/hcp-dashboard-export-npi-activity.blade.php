<div>
    <button wire:click="confirmNpiExport" wire:loading.attr="disabled" type="button" class="float-right inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-evoke hover:bg-evoke-tertiary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-evoke-tertiary">
        Export NPI Activity
        <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 -mr-1 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z" />
            <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z" />
            <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z" />
        </svg>
    </button>

    @php

        $date_difference_in_days = 0;
        if(time() > strtotime($start_date)){
            $date_difference = time() - strtotime($start_date);
            $date_difference_in_days = round($date_difference / (60 * 60 * 24));
        }

    @endphp

    <!-- Export Npi Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingNpiExport">
        <x-slot name="title">
            {{ __('NPI Activity Export') }}
        </x-slot>

        @if(count($floodlights) == 0)
            <x-slot name="content">
                There are currently no floodlight tags on the advertiser account.
            </x-slot>
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingNpiExport')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>
            </x-slot>
        @else
            <x-slot name="content">

                {{ __('Date Range of Report: :startdate to :enddate', ['startdate' => $start_date, 'enddate' => $end_date]) }}
                <br/><br/>

                @if($date_difference_in_days > 90)
                    @include('components.export-not-available')

                @else

                <p>Please select the activities you would like to include in the report:</p>
                <p>
                    <select name="activities" wire:model="activities" multiple class="text-sm w-full mr-4" size="10">
                        @foreach($floodlights as $fl)
                        <option value="{{$fl->id}}">{{$fl->name}}</option>
                        @endforeach
                    </select>
                    <div class="text-xs">CTRL + Click to select multiple.</div>
                </p>
                <br/>
                {{ __('After clicking "Export", you will be emailed a csv file when the process completes.  Depending on the speed of DFA reporting this is usually 1-3 hours.') }}
                <dl>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Email Address
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="w-0 flex-1 flex items-center">
                                            <!-- Heroicon name: solid/paper-clip -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                {{ Auth::user()->email }}
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </dd>
                    </div>
                </dl>
                @endif
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingNpiExport')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                @if($isDisabled)
                    <x-jet-button class="ml-2" wire:click="export" wire:loading.attr="disabled">
                        {{ __('Export') }}
                    </x-jet-button>
                @else
                    <x-jet-button class="ml-2 {{($date_difference_in_days > 90) ? 'cursor-not-allowed' : '' }}" wire:click="export" disabled="disabled">
                        {{ __('Export') }}
                    </x-jet-button>
                @endif

            </x-slot>
        @endif
    </x-jet-confirmation-modal>
</div>
