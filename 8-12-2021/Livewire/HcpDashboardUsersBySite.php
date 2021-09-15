<?php

namespace App\Http\Livewire;

use App\Google\Services\Analytics\AnalyticsReader;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HcpDashboardUsersBySite extends Component
{

    public $sites;

    public $start_date = "30daysAgo";

    public $end_date = "today";

    //we may need to change this to fire off a method that has a date parameter
    protected $listeners = ['dateChanged' => 'dateChanged'];

    public function dateChanged($dates, AnalyticsReader $reader){
        $this->start_date = $dates['start_date'];
        $this->end_date = $dates['end_date'];
        $this->mount($reader, Auth::user()->currentTeam);

    }

    public function mount(AnalyticsReader $reader, Team $team){

        $this->sites = $reader
            ->reportRequest($team->ga_view_id, $this->start_date, $this->end_date)
            ->withDimensions(["ga:source"])
            ->withMetrics(["ga:users", "ga:newUsers"])
            ->withDimensionFilter($team->getGASitesDimensionFilters())
            ->submit("array");

        $this->sites = $reader
            ->changeSourceToMediaPartnerName($this->sites,$team->mediaPartners()->get());
    }
    public function render()
    {
        return view('livewire.hcp-dashboard-users-by-site');
    }
}
