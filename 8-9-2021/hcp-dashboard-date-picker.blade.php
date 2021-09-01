<div>
    <form name="updateDateForm" wire:submit.prevent="updateDate">
        <div class="mt-3 grid grid-cols-2 gap-6 reporting-dates">
            <div>
                <x-jet-label for="name" value="{{ __('Start Date') }}"/>
                <div class="form-text-container flex rounded-sm shadow-sm relative">
                    <span class="leading-addon cursor-pointer inline-flex items-center px-3 rounded-l-md border border-r-0 border-blue-gray-300 bg-blue-gray-50 text-blue-gray-500 sm:text-sm" title="Select a date">
                        <span class="h-5 w-5 text-blue-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>            
                        </span>
                    </span>

                    <input class="form-input form-text flex-1 block w-full" placeholder="Y-m-d" type="text" name="start_date" wire:model="start_date"  id="start_date">
                    <input type="hidden" name="flight_starting_date" id="flight_starting_date" value="{{$startingDate->flight_start_date}}">

                </div>
            </div>
            <div>
                <x-jet-label for="name" value="{{ __('End Date') }}"/>
                <div class="form-text-container flex rounded-sm shadow-sm relative">
                    <span class="leading-addon cursor-pointer inline-flex items-center px-3 rounded-l-md border border-r-0 border-blue-gray-300 bg-blue-gray-50 text-blue-gray-500 sm:text-sm" title="Select a date">
                        <span class="h-5 w-5 text-blue-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>            
                        </span>
                    </span>
                    @if($start_date)
                        <input class="form-input form-text flex-1 block w-full" placeholder="Y-m-d" type="text" name="end_date" wire:model="end_date"  id="end_date">
                    @else
                        <input class="form-input form-text flex-1 block w-full disabled:opacity-50 cursor-not-allowed" placeholder="Y-m-d" type="text" name="end_date" wire:model="end_date"  id="end_date" disabled>
                    @endif

                </div>
            </div> 
        </div>
    </form>
</div>
