require('./bootstrap');
require('alpinejs');



import flatpickr from "flatpickr";
import * as FilePond from "filepond";
import { createPopper } from "@popperjs/core";

window.flatpickr = flatpickr;
window.FilePond = FilePond;
window.createPopper = createPopper;


var element = document.querySelector("#flight_starting_date");
if (element) {
	var flight_starting_date = element.value;
}
window.flatpickr = flatpickr("#reportingDates", {
	mode: "range",
    minDate: flight_starting_date,
    dateFormat: "Y-m-d",
    onChange: function(selectedDates, dateString, instance) {

    	var flight_starting_date_day = new Date(flight_starting_date).getDate();
    	var flight_starting_date_month = new Date(flight_starting_date).getMonth();
    	var flight_starting_date_year = new Date(flight_starting_date).getFullYear();

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
});

window.flatpickr = flatpickr("#flight_start_date_in_create_page", {dateFormat: "Y-m-d"});
window.flatpickr = flatpickr("#flight_start_date_in_update_page", {dateFormat: "Y-m-d"});


require('./npis');
