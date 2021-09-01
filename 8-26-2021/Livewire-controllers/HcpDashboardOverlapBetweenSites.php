<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MediaPartnerULD;
use App\Models\MediaPartner;
use App\Models\Team;
use DB, Auth, User, Session;

class HcpDashboardOverlapBetweenSites extends Component
{

    public $overlappedBetweenMediaPartners;

    public $start_date;

    public $end_date;

    
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

        $MediaPartners = DB::select('SELECT id, media_partner_name FROM `media_partners` WHERE team_id ='.(int)Auth::user()->current_team_id );
 
        $results = array(array()); 
        $combinations = array();

        foreach ($MediaPartners as $MediaPartner) {
            foreach ($results as $combination){
                array_push($results, array_merge(array($MediaPartner), $combination));
            }
        }

        foreach($results as $set){
            if(count($set) > 2 or count($set) < 2) continue;
            $combinations[] = $set;
        }

        $totalNpiReachedCount = DB::table('npis')->where('team_id', Auth::user()->current_team_id)->count();

        if ($combinations) {
            foreach ($combinations as $combination) {
                $overLappedNpis = 0; $percentageNpiReached = 0.00;
                $overlapped_npi_result= DB::select("SELECT distinct U.npi AS npi 
                                        FROM `media_partner_uld` U 
                                        Inner Join media_partners M on M.id=U.media_partner_id 
                                        WHERE M.team_id= ".(int) Auth::user()->current_team_id." 
                                        AND U.date >= '".$this->start_date."'
                                        AND U.date <= '".$this->end_date."'
                                        AND U.media_partner_id in(".$combination[0]->id.",".$combination[1]->id.")
                                        AND U.npi in (select DISTINCT npi FROM `npis` Where team_id=".(int) Auth::user()->current_team_id.") 
                                        Group by U.npi 
                                        having count(DISTINCT M.id) > 1 
                                        order by U.npi");

                $overLappedNpis = count($overlapped_npi_result);

                if ($overLappedNpis > 0 && $totalNpiReachedCount > 0) {
                    $percentageNpiReached = ($overLappedNpis / $totalNpiReachedCount ) * 100;
                    $percentageNpiReached = number_format((float)$percentageNpiReached, 2, '.', '');
                }

                $temp_array['combination'] = $combination;
                $temp_array['overLappedNpis'] = $overLappedNpis;
                $temp_array['totalNpiReachedCount'] = $totalNpiReachedCount;
                $temp_array['percentage_reached'] = $percentageNpiReached;
                $this->overlappedBetweenMediaPartners[] = $temp_array;
                unset($temp_array);

            }
        }

    }


    public function render()
    {
        return view('livewire.hcp-dashboard-overlap-between-sites');
    }
}
