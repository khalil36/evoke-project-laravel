<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MediaPartnerULD;
use App\Models\MediaPartner;
use DB, Auth, User, Session;

class HcpDashboardNpiReach extends Component
{
    public $uniqueNpiCount;
    public $totalNpiReachedCount;
    public $percentageNpiReached;
    public $overLappedNpis;

    //we may need to change this to fire off a method that has a date parameter
    protected $listeners = ['dateChanged' => 'mount'];

    public function mount(){
        
        $this->uniqueNpiCount = DB::table('media_partner_uld')
                            ->select('media_partner_uld.npi')
                            ->distinct('npi')
                            ->join('media_partners', 'media_partners.id', '=', 'media_partner_uld.media_partner_id')
                            ->where('media_partners.team_id', Auth::user()->current_team_id)
                            ->count();



      
        $this->totalNpiReachedCount = DB::table('media_partner_uld')
                            ->select('media_partner_uld.npi')
                            ->join('media_partners', 'media_partners.id', '=', 'media_partner_uld.media_partner_id')
                            ->where('media_partners.team_id', Auth::user()->current_team_id)
                            ->count();
        
        $this->percentageNpiReached = ($this->uniqueNpiCount / $this->totalNpiReachedCount ) * 100;
        $this->percentageNpiReached = number_format((float)$this->percentageNpiReached, 2, '.', '');


        //SELECT COUNT(`npi`) as totalNPIs, npi, media_partner_id FROM `media_partner_uld` LEFT JOIN `media_partners` ON `media_partner_uld`.`media_partner_id` = `media_partners`.`id` WHERE `media_partners`.`team_id`=1 GROUP BY `media_partner_id`,`npi`

         // $this->overLappedNpis = DB::table('media_partner_uld')
         //                            ->select(COUNT('npi'), 'npi', 'media_partner_id')
         //                            ->join('media_partners', 'media_partners.id', '=', 'media_partner_uld.media_partner_id')
         //                            ->where('media_partners.team_id', Auth::user()->current_team_id)
         //                            ->groupBy( 'media_partner_id','npi')
         //                            ->get();

        //$overlapped_npi_result = DB::select("SELECT COUNT(`npi`) as totalNPIs, npi, media_partner_id FROM `media_partner_uld` LEFT JOIN `media_partners` ON `media_partner_uld`.`media_partner_id` = `media_partners`.`id` WHERE `media_partners`.`team_id`=1 GROUP BY `media_partner_id`,`npi`");

        $overlapped_npi_result = DB::table('media_partner_uld')
                                    ->select('npi')
                                    ->join('media_partners', 'media_partners.id', '=', 'media_partner_uld.media_partner_id')
                                    ->where('media_partners.team_id', Auth::user()->current_team_id)
                                    ->groupBy( 'media_partner_id','npi')
                                    ->get();

        foreach ($overlapped_npi_result as $key => $value) {
            foreach ($value as $key => $val) {
               // if($key == 'npi'){ 
                    $all_npis[] = $val;
                //}
            }
        }

        // echo '<pre> temp1231: ';print_r($tmparr); 
        // print_r(array_unique($tmparr));

        $overlapped_npis = array_diff_assoc($all_npis, array_unique($all_npis));
        $this->overLappedNpis = count($overlapped_npis);
        

    }

    public function render()
    {
        return view('livewire.hcp-dashboard-npi-reach');
    }
}
