require('./bootstrap');
require('alpinejs');



import flatpickr from "flatpickr";
import * as FilePond from "filepond";
import { createPopper } from "@popperjs/core";

window.flatpickr = flatpickr;
window.FilePond = FilePond;
window.createPopper = createPopper;


// var element = document.querySelector("#flight_starting_date");
// if (element) {
// 	var flight_starting_date = element.value;
// }
// window.flatpickr = flatpickr("#reportingDates", {
// 	mode: "range",
//     minDate: flight_starting_date,
//     dateFormat: "Y-m-d",
//     onChange: function(selectedDates, dateString, instance) {

//     	var flight_starting_date_day = new Date(flight_starting_date).getDate();
//     	var flight_starting_date_month = new Date(flight_starting_date).getMonth();
//     	var flight_starting_date_year = new Date(flight_starting_date).getFullYear();

//     	if (selectedDates.length == 1 ){

//     		var first_selected_day = new Date(selectedDates).getDate();

//     		for (var i = flight_starting_date_month; i <= 11; i++) {

//     			var first_day_of_month = '';
//     			var selected_month_1 = new Date(selectedDates).getMonth();
//     			first_day_of_month = new Date(flight_starting_date_year, flight_starting_date_month + i, 1).getDate();

//     			//console.log(`---first_day_of_month: ${first_day_of_month} --- selected_month_1: ${selected_month_1} ----flight_starting_date_month: ${flight_starting_date_month}`);

//     			if (flight_starting_date_month == selected_month_1) {
//     				if (flight_starting_date_day != first_selected_day){
//     					this.clear();
//     					alert(`Please select first active day like (${flight_starting_date_day})`);
// 		    			break;
//     				}
//     			} else if(first_day_of_month != first_selected_day && flight_starting_date_month != selected_month_1){
//     				this.clear();
//     				alert(`Please select first day of the month (${first_day_of_month})`);
// 		    		break;
//     			}
		    
//     		}

//     	} else if (selectedDates.length > 1 ) {
// 	    	var selected_dates = dateString.split('to');
// 	    	var second_selected_date = selected_dates[1].split('-');
// 	    	var selected_year = second_selected_date[0];
// 	    	var selected_month_2 = second_selected_date[1];
// 	    	var second_selected_day = second_selected_date[2];

// 	    	var last_day_of_month = new Date(selected_year, selected_month_2, 0);
// 	    	last_day_of_month = new Date(last_day_of_month).getDate();
// 	    	if (second_selected_day != last_day_of_month) {
// 	    		this.clear();
// 	    		alert(`You can select only last day of the monthe like (${last_day_of_month})`);
// 	    	}
//     	}
//     }
// });


var element = document.querySelector("#flight_starting_date");
if (element) {
	var flight_starting_date = element.value;
}

const end_date = flatpickr("#end_date", {
	minDate: flight_starting_date,
	dateFormat: "Y-m-d",
	enable: [
		function(date) {
	        return (date.getDate() === new Date(date.getFullYear(), date.getMonth()+1, 0).getDate() );
	    }
	],
	onClose: function(selectedDates, dateString, instance) {
		// if (dateString) {
		// console.log(start_date.selectedDates +' ---- '+selectedDates);
		// console.log(`start_date: ${start_date.selectedDates[0].getTime()} ----- selectedDates: ${selectedDates[0].getTime()}`);
	}


		// if (dateString) {
	 //    	if (start_date.selectedDates[0].getTime() > instance.getTime()) {
	 //    		this.clear();
	 //     		alert(`Please reset your end date once again.`);
	 //    	}
		// }
   // }
});


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
		//console.log(`>>>>>>dateString : ${end_date.dateString} ----selectedDates: ${end_date.selectedDates}`);
		if (dateString && end_date.selectedDates != '') {

			// console.log(end_date.selectedDates +' ---- '+selectedDates);
			// console.log(`start_date: ${end_date.selectedDates[0].getTime()} ----- selectedDates: ${selectedDates[0].getTime()}`);

			if (end_date.selectedDates[0].getTime() < selectedDates[0].getTime()) {
				end_date.clear();
		 		alert(`Please reset your end date once again.`);
			}
		}
    }

});



const create_page = flatpickr("#flight_start_date_in_create_page", {dateFormat: "Y-m-d"});
const update_page = flatpickr("#flight_start_date_in_update_page", {dateFormat: "Y-m-d"});


require('./npis');
