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

const start_date = flatpickr("#start_date", {
	minDate: flight_starting_date,
	dateFormat: "Y-m-d",
	enable: [
        function(date) {
        	var starting_day = new Date(flight_starting_date).getDate();
        	var starting_month = new Date(flight_starting_date).getMonth();
        	var starting_year = new Date(flight_starting_date).getFullYear();
        	return (( date.getDate() < 2 ) || ( date.getDate() == starting_day && date.getMonth() == starting_month && date.getFullYear() == starting_year ) );
   
        }
    ],
    onClose: function(selectedDates, dateString, instance) {
    	end_date.redraw();
    	//console.log('enable:' + );
		if (dateString && end_date.selectedDates != '') {
			if (end_date.selectedDates[0].getTime() < selectedDates[0].getTime()) {
				end_date.clear();
			}
		}
    }

});

const end_date = flatpickr("#end_date", {
	minDate: flight_starting_date,
	dateFormat: "Y-m-d",
	enable: [
		function(date) {
			//console.log('date:' + date);
			if (start_date.selectedDates != ''){
				var end_day = new Date(start_date.selectedDates[0].getFullYear(), start_date.selectedDates[0].getMonth()-1, 0).getDate();
				//var end_day = new Date(flight_starting_date).getDate();
	        	var end_month = new Date(start_date.selectedDates[0]).getMonth();
	        	var end_year = new Date(start_date.selectedDates[0]).getFullYear();
				console.log(`end_day: ${end_day} --- end_month: ${end_month} ---- end_year: ${end_year} ---end, getMonth: ${new Date(end_year, end_month, 0).getMonth()}`);
				return ( ( date.getTime() >= start_date.selectedDates[0].getTime() ) && date.getDate() === new Date(date.getFullYear(), date.getMonth()+1, 0).getDate());
	         	// return (date.getDate() === new Date(date.getFullYear(), date.getMonth()+1, 0).getDate() || 
	         	// 	( date.getDate() == end_day && date.getMonth() == end_month && date.getFullYear() == end_year ));

			} else {
	        	return false;
			}
	    }
	],

	onClose: function(selectedDates, dateString, instance) {
		if (dateString && start_date.selectedDates != '') {
			if (start_date.selectedDates[0].getTime() > selectedDates[0].getTime()) {
				start_date.clear();
			}
		}
	}
});


const create_page = flatpickr("#flight_start_date_in_create_page", {dateFormat: "Y-m-d"});
const update_page = flatpickr("#flight_start_date_in_update_page", {dateFormat: "Y-m-d"});


require('./npis');
