<div>
    <form name="updateDateForm" wire:submit.prevent="updateDate">
        
        <div class="mt-3 grid grid-cols-2 reporting-dates">
            <div class="mr-5">
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

                    <input class="form-input form-text flex-1 block w-full" placeholder="Y-m-d" type="text" name="end_date" wire:model="end_date"  id="end_date">

                </div>
            </div>

            <!-- <div class="form-text-container flex rounded-sm shadow-sm relative">
                <span class="leading-addon cursor-pointer inline-flex items-center px-3 rounded-l-md border border-r-0 border-blue-gray-300 bg-blue-gray-50 text-blue-gray-500 sm:text-sm" title="Select a date">
                    <span class="h-5 w-5 text-blue-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>            
                    </span>
                </span>

                <input class="form-input form-text flex-1 block w-full" placeholder="Y-m-d" type="text" name="reportingDates" wire:model="reportingDates"  id="reportingDates">
                <input type="hidden" name="flight_starting_date" id="flight_starting_date" value="{{$startingDate->flight_start_date}}">

            </div> -->
            <!-- <x-date-picker 
                id="reportingDates" 
                wire:model="reportingDates" 
                name="reportingDates" 
                :options='[
                    "mode" => "range",
                    "clickOpens" => true,
                    "allowInput" => false,
                    "minDate" => "$startingDate->flight_start_date",
                ]'
            > 
            <x-slot name="optionsSlot">
                onChange: function(selectedDates, dateString, instance) {

                var flight_starting_date_day = new Date(<?= $startingDate->flight_start_date ?>).getDate();
                var flight_starting_date_month = new Date(<?=$startingDate->flight_start_date?>).getMonth();
                var flight_starting_date_year = new Date(<?=$startingDate->flight_start_date?>).getFullYear();

                if (selectedDates.length == 1 ){

                    var first_selected_day = new Date(selectedDates).getDate();

                    for (var i = flight_starting_date_month; i <= 11; i++) {

                        var first_day_of_month = '';
                        var selected_month_1 = new Date(selectedDates).getMonth();
                        first_day_of_month = new Date(flight_starting_date_year, flight_starting_date_month + i, 1).getDate();

                        //console.log(`---first_day_of_month: ${first_day_of_month} --- selected_month_1: ${selected_month_1} ----flight_starting_date_month: ${flight_starting_date_month}`);

                        if (flight_starting_date_month == selected_month_1) {
                            if (flight_starting_date_day != first_selected_day){
                                this.clear();
                                alert(`Please select first active day like (${flight_starting_date_day})`);
                                break;
                            }
                        } else if(first_day_of_month != first_selected_day && flight_starting_date_month != selected_month_1){
                            this.clear();
                            alert(`Please select first day of the month (${first_day_of_month})`);
                            break;
                        }
                    
                    }

                } else if (selectedDates.length > 1 ) {
                    var selected_dates = dateString.split('to');
                    var second_selected_date = selected_dates[1].split('-');
                    var selected_year = second_selected_date[0];
                    var selected_month_2 = second_selected_date[1];
                    var second_selected_day = second_selected_date[2];

                    var last_day_of_month = new Date(selected_year, selected_month_2, 0);
                    last_day_of_month = new Date(last_day_of_month).getDate();
                    if (second_selected_day != last_day_of_month) {
                        this.clear();
                        alert(`You can select only last day of the monthe like (${last_day_of_month})`);
                    }
                }
            }
            </x-slot>
            </x-date-picker> -->
       
                    

        </div>
    </form>
</div>
