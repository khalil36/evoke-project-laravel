<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MediaPartner;
use App\Models\Team;
use Auth;

class HcpDashboardSearch extends Component
{
    public $search_table_data = [];
    public $start_date;
    public $end_date;
    public $clicks = 30;

     //we may need to change this to fire off a method that has a date parameter
    protected $listeners = ['dateChanged' => 'dateChanged'];

    public function dateChanged($dates)
    {
        $this->start_date = $dates['start_date'];
        $this->end_date = $dates['end_date'];
        $this->mount();
    }

    public function mount()
    {   
        
        $tmp_array = $this->search_table_data = [];

        if (!empty($this->end_date) && !empty($this->start_date)) {
            $this->clicks++;
        } 

        $get_media_partners = MediaPartner::where('team_id', Auth::user()->current_team_id)->get();

        if (!empty($get_media_partners)) {
            foreach ($get_media_partners as $media_partner) {

                $tmp_array['media_partner_name'] = $media_partner->media_partner_name;
                $tmp_array['clicks'] = $this->clicks;

                $this->search_table_data[] = $tmp_array;
                unset($tmp_array);
            }
        }
    
    }

    public function render()
    {
        return view('livewire.hcp-dashboard-search');
    }
}
