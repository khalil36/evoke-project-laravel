<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MediaPartnerULD;
use App\Models\MediaPartner;
use DB, Auth, User, Session;

class HcpDashboardOverlapBetweenSites extends Component
{

    public $totalNpiReachedCount;
    public $percentageNpiReached = 0.00;
    public $overLappedNpis;
    public $overlappedBetweenMediaPartners;

    public function mount(){

        // $set = array(
        //     '0'=> 'google', 
        //     '1'=> 'bing', 
        //     '2'=> 'yahooo', 
        //     '3'=> 'khalil'
        // ); 
       $MediaPartners = DB::select('SELECT id, media_partner_name FROM `media_partners` WHERE team_id ='.(int)Auth::user()->current_team_id );
 
        $results = array(array()); 
        foreach ($MediaPartners as $element) {
            foreach ($results as $combination){
                array_push($results, array_merge(array($element), $combination)); 
            } 
        }

        //echo"<pre>results: ";print_r($results); 

        foreach($results as $set){
            if(count($set) > 2 or count($set) < 2) continue;
            $combinations[] = $set;
        }

        //echo "<pre>combinations: "; print_r($combinations);
        $this->totalNpiReachedCount = DB::table('npis')->where('team_id', Auth::user()->current_team_id)->count();

        foreach ($combinations as $combination) {
            // echo "<pre>combination: "; print_r($combination);
            // echo "id ". $combination[0]->id;
            // echo " -- id ". $combination[1]->id; exit();

            $overlapped_npi_result= DB::select("SELECT U.npi AS npi 
                                    FROM `media_partner_uld` U 
                                    Inner Join media_partners M on M.id=U.media_partner_id 
                                    WHERE M.team_id= ".(int) Auth::user()->current_team_id." 
                                    AND U.npi in (select DISTINCT npi FROM `npis` Where team_id=".(int) Auth::user()->current_team_id.") 
                                    AND U.media_partner_id in(".$combination[0]->id.",".$combination[1]->id.")
                                    Group by U.npi 
                                    having count(DISTINCT M.id) > 1 
                                    order by U.npi");

            $this->overLappedNpis = count($overlapped_npi_result);

            if ($this->overLappedNpis > 0 && $this->totalNpiReachedCount > 0) {
                $this->percentageNpiReached = ($this->overLappedNpis / $this->totalNpiReachedCount ) * 100;
                $this->percentageNpiReached = number_format((float)$this->percentageNpiReached, 2, '.', '');
            }

            $temp_array['combination'] = $combination;
            $temp_array['overLappedNpis'] = $this->overLappedNpis;
            $temp_array['totalNpiReachedCount'] = $this->totalNpiReachedCount;
            $temp_array['percentage_reached'] = $this->percentageNpiReached ?? 0;
            $this->overlappedBetweenMediaPartners[] = $temp_array;
            unset($temp_array);

        }

    }


    public function render()
    {
        return view('livewire.hcp-dashboard-overlap-between-sites');
    }
}
