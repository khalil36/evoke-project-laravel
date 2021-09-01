<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MediaPartnerULD;
use App\Models\MediaPartner;
use App\Models\Team;
use DB, Auth, User, Session;


class HcpDashboardUldBySite extends Component
{

    public $mediaPartnersFullData= array();

    public $start_date;

    public $end_date;

    protected $listeners = ['dateChanged' => 'dateChanged'];

    public function dateChanged($dates){
        $this->start_date = $dates['start_date'];
        $this->end_date = $dates['end_date'];

        $this->mount();
    }


    public function mount(){

        if (empty($this->end_date) && empty($this->start_date)) {
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

        $this->mediaPartnersFullData= array();

        $get_media_partners = MediaPartner::where('team_id', Auth::user()->current_team_id)->get();

        if ($get_media_partners) {

            foreach ($get_media_partners as $media_partner) {
                
                $percentageNpiReached = 0.00;
                $uniqueNpisOfMediaParter = 0;
                $totalNpis = 0;

                $unique_npi_result= DB::select("SELECT DISTINCT U.npi
                                    FROM media_partners M
                                    Inner Join `media_partner_uld` U on M.id = U.media_partner_id
                                    WHERE M.team_id = ".(int) Auth::user()->current_team_id."
                                    AND U.date >= '".$this->start_date."'
                                    AND U.date <= '".$this->end_date."'
                                    AND U.media_partner_id = ".$media_partner->id."
                                    AND U.npi in (select DISTINCT npi FROM `npis` Where team_id = ".(int) Auth::user()->current_team_id." )");

                $uniqueNpisOfMediaParter = count($unique_npi_result);

                $totalNpis = DB::table('npis')->where('team_id', Auth::user()->current_team_id)->count();

                if ($uniqueNpisOfMediaParter > 0 and $totalNpis > 0) {
                    $percentageNpiReached = ($uniqueNpisOfMediaParter / $totalNpis) * 100;
                    $percentageNpiReached = number_format((float)$percentageNpiReached, 2, '.', '');
                }

                $temp_array['media_partner_name'] = $media_partner->media_partner_name;
                $temp_array['unique_npis'] = $uniqueNpisOfMediaParter;
                $temp_array['percentage_reached'] = $percentageNpiReached;
                $this->mediaPartnersFullData[] = $temp_array;
                unset($temp_array);

            }
        }

    }


    public function render()
    {
        return view('livewire.hcp-dashboard-uld-by-site');
    }
}
