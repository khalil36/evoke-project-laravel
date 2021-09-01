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

        	const starting_date =  new Date(flight_starting_date+' 00:00:00');
        	const starting_day = starting_date.getDate();
        	const starting_month = starting_date.getMonth();
        	const starting_year = starting_date.getFullYear();

        	return (( date.getDate() < 2 ) || ( date.getDate() == starting_day && (date.getMonth() == starting_month && date.getFullYear() == starting_year )) );
        }
    ],
    onClose: function(selectedDates, dateString, instance) {
    	end_date.clear();
    	end_date.redraw();

    }

});

const end_date = flatpickr("#end_date", {
	minDate: flight_starting_date,
	dateFormat: "Y-m-d",
	enable: [
		function(date) {
			
			if (start_date.selectedDates != ''){
				return ( date.getTime() >= start_date.selectedDates[0].getTime() && date.getDate() === new Date(date.getFullYear(), date.getMonth()+1, 0).getDate());
			} else {
	        	return false;
			}
	    }
	],
	onDayCreate: function(dObj, dStr, fp, dayElem){

		const calander_date = new Date(dayElem.dateObj);
		const current_date = new Date();
		const current_month = current_date.getMonth();
		const current_year = current_date.getFullYear();
		const current_date_firstDay = new Date(current_year , current_month, 1).getDate();
		const current_date_lastDay = new Date(current_year , current_month + 1, 0).getDate();
		const lll = [current_year, current_month+1, current_date_firstDay].join('-');

		//console.log(` ----dObj: ${dObj} --- dStr: ${dStr} --- fp: ${fp} ---dayElem: ${dayElem} ----dayElem: ${dayElem.dateObj}  `);
		//console.log(`lll: ${lll}  ---- end_date: ${end_date.date} --- current_date: ${current_date} --- current_date: ${current_date.getTime()} -- dStr: ${dStr}`);
         if (( calander_date.getDate() === current_date.getDate() && (calander_date.getMonth() == current_month && calander_date.getFullYear() == current_year ) ) )
         //if(calander_date.getTime() === current_date.getTime())
        {
        	dayElem.classList.add("text-color");
        }
    }
});


const create_page = flatpickr("#flight_start_date_in_create_page", {dateFormat: "Y-m-d"});
const update_page = flatpickr("#flight_start_date_in_update_page", {dateFormat: "Y-m-d"});


require('./npis');
