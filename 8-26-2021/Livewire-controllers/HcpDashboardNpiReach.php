<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MediaPartnerULD;
use App\Helpers\Helpers;
use DB, Auth, User, Session;
use App\Models\Team;


class HcpDashboardNpiReach extends Component
{
    public $uniqueNpiCount;
    public $totalNpiReachedCount;
    public $percentageNpiReached = 0.00;
    public $overLappedNpis;

    // public $start_date = "2020-06-07";

    // public $end_date = "2021-08-26";
    public $start_date;

    public $end_date;


    //we may need to change this to fire off a method that has a date parameter
    protected $listeners = ['dateChanged' => 'dateChanged'];

    public function dateChanged($dates){
        $this->start_date = $dates['start_date'];
        $this->end_date = $dates['end_date'];
        $this->mount();
    }

    public function mount(){

        $this->percentageNpiReached = 0.00;

        if (!$this->end_date && !$this->start_date) {

           // Helpers::testFunction();
            $team = Team::find(Auth::user()->current_team_id);

            $this->start_date = $team->flight_start_date;

            $flight_start_date_year_month = date('Y-m', strtotime($this->start_date));
            $current_year_month = date('Y-m');

            if ($flight_start_date_year_month == $current_year_month) {
                $this->end_date = date("Y-m-t");
            } elseif ($flight_start_date_year_month < $current_year_month) {
                $this->end_date = date('Y-m-d', strtotime('last day of previous month'));
            } else {
                $this->end_date = date('Y-m-t', strtotime($this->start_date));
            }
        }

        $unique_npi_result= DB::select("SELECT DISTINCT U.npi
                            FROM media_partners M
                            Inner Join `media_partner_uld` U on M.id = U.media_partner_id
                            WHERE M.team_id = ".(int) Auth::user()->current_team_id."
                            AND U.date >= '".$this->start_date."'
                            AND U.date <= '".$this->end_date."'
                            AND U.npi in (select DISTINCT npi FROM `npis` Where team_id = ".(int) Auth::user()->current_team_id." )");

        $this->uniqueNpiCount = count($unique_npi_result);

        $this->totalNpiReachedCount = DB::table('npis')->where('team_id', Auth::user()->current_team_id)->count();

        if ($this->uniqueNpiCount > 0 && $this->totalNpiReachedCount > 0) {
            $this->percentageNpiReached = ($this->uniqueNpiCount / $this->totalNpiReachedCount ) * 100;
            $this->percentageNpiReached = number_format((float)$this->percentageNpiReached, 2, '.', '');
        }

        $overlapped_npi_result= DB::select("SELECT U.npi AS npi
                                FROM `media_partner_uld` U
                                Inner Join media_partners M on M.id=U.media_partner_id
                                WHERE M.team_id= ".(int) Auth::user()->current_team_id."
                                AND U.date >= '".$this->start_date."'
                                AND U.date <= '".$this->end_date."'
                                AND U.npi in (select DISTINCT npi FROM `npis` Where team_id=".(int) Auth::user()->current_team_id.")
                                Group by U.npi
                                having count(DISTINCT M.id) > 1
                                order by U.npi");

        $this->overLappedNpis = count($overlapped_npi_result);


    }

    public function render()
    {
        return view('livewire.hcp-dashboard-npi-reach');
    }
}
