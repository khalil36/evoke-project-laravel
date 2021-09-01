<?php

namespace App\Helpers;
use App\Models\Team;

class Helpers
{
	public static function getHcpInitialDates($start_date = null){

		$flight_start_date_year_month = date('Y-m', strtotime($start_date));
		$current_year_month = date('Y-m');

		if ($flight_start_date_year_month == $current_year_month) {
		   // $this->end_date = date("Y-m-t");
			return date("Y-m-t");
		} elseif ($flight_start_date_year_month < $current_year_month) {
		   // $this->end_date = date('Y-m-d', strtotime('last day of previous month'));
			return date('Y-m-d', strtotime('last day of previous month'));
		} else {
		   // $this->end_date = date('Y-m-t', strtotime($this->start_date));
			return date('Y-m-t', strtotime($start_date));
		}
	} 
}