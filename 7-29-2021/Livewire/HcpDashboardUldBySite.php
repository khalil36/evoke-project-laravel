<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MediaPartnerULD;
use App\Models\MediaPartner;
use DB, Auth, User, Session;


class HcpDashboardUldBySite extends Component
{

    public $mediaPartnersFullData= array();
    

    public function mount(){

        $get_media_partners = MediaPartner::where('team_id', Auth::user()->current_team_id)->paginate(20);
        
        if ($get_media_partners) {
           
            foreach ($get_media_partners as $media_partner) {

                // $uniqueNpisOfMediaParter = MediaPartnerULD::select('npi')
                //                             ->distinct('npi')
                //                             ->join('media_partners', 'media_partners.id', '=', 'media_partner_id')
                //                             ->where('media_partners.team_id', Auth::user()->current_team_id)
                //                             ->where('media_partner_id', $media_partner->id)
                //                             ->whereIn('npi', function($query){
                //                                 $query->select("select DISTINCT npi FROM `npis` Where team_id= ".(int) Auth::user()->current_team_id)
                //                             });
                                            //->count();
                                            //->whereIn("select DISTINCT npi FROM `npis` Where team_id= ".(int) Auth::user()->current_team_id ." in(npi)")

                                            // Products::whereIn('id', function($query){
                                            //     $query->select('paper_type_id')
                                            //     ->from(with(new ProductCategory)->getTable())
                                            //     ->whereIn('category_id', ['223', '15'])
                                            //     ->where('active', 1);
                                            // })->get();

                // $totalNpis = MediaPartnerULD::select('npi')
                //                             ->join('media_partners', 'media_partners.id', '=', 'media_partner_id')
                //                             ->where('media_partners.team_id', Auth::user()->current_team_id)
                //                             ->count();

                $unique_npi_result= DB::select("SELECT DISTINCT U.npi 
                                    FROM media_partners M 
                                    Inner Join `media_partner_uld` U on M.id = U.media_partner_id 
                                    WHERE M.team_id = ".(int) Auth::user()->current_team_id." 
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
                $temp_array['percentage_reached'] = $percentageNpiReached ?? 0;
                $this->mediaPartnersFullData[] = $temp_array;
                unset($temp_array);

            }
        }

    }


    public function render()
    {
        return view('livewire.hcp-dashboard-uld-by-site', ['mediaPartnerPagination'=> MediaPartner::where('team_id', Auth::user()
            ->current_team_id)->paginate(20)]);
    }
}
