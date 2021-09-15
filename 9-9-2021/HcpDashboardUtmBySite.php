<?php

namespace App\Http\Livewire;

use App\Google\Services\Analytics\AnalyticsReader;
use App\Google\Services\Analytics\DfaReader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Helpers\Helpers;


class HcpDashboardUtmBySite extends Component
{
    public $start_date;

    public $end_date;

    public $sites = [];

    public $readyToLoad = false;

    protected $listeners = ['dateChanged' => 'dateChanged'];

    public function loadSites(DfaReader $reader){
        $this->readyToLoad = true;
        $this->mount(App::make(DfaReader::class), App::make(AnalyticsReader::class), Auth::user()->currentTeam);

    }

    public function dateChanged($dates, DfaReader $reader, AnalyticsReader $analyticsReader){
        $this->start_date = $dates['start_date'];
        $this->end_date = $dates['end_date'];
        $this->mount($reader, $analyticsReader, Auth::user()->currentTeam);

    }

    public function mount(DfaReader $reader, AnalyticsReader $analyticsReader, $team){

        if (empty($this->end_date) && empty($this->start_date)) {
            $dates = Helpers::getHcpInitialDates($team->id);
            $this->start_date = $dates['start_date'];
            $this->end_date = $dates['end_date'];
        }

        if($this->readyToLoad) {
            $dfp_data = $reader->getReachReport($team,$this->start_date, $this->end_date);
            $analyticsReader = App::make(AnalyticsReader::class);

            $ga_data = $analyticsReader
                ->reportRequest($team->ga_view_id, $this->start_date, $this->end_date)
                ->withDimensions(["ga:source"])
                ->withMetrics(["ga:users", "ga:newUsers"])
                ->withDimensionFilter($team->getGASitesDimensionFilters())
                ->submit("array");

            $data_for_table = [];
            $partners = $team->mediaPartners()->get();
            foreach($partners as $p){

                $d['name'] = $p->media_partner_name;
                $index = array_search($p->ga_site_source, array_column($ga_data, 'ga:source'));
                if($index !==false) {
                    $d['new_users'] = $ga_data[$index]["ga:newUsers"];
                }else{
                    $d['new_users'] = 0;
                }

                $d['unique_click_reach'] = $reader->getReachReportColumn($p->dfa_site, 'Unique Reach: Click Reach', $dfp_data);
                $d['unique_impression_reach'] = $reader->getReachReportColumn($p->dfa_site, 'Unique Reach: Impression Reach', $dfp_data);
                $d['unique_avg_impression_freq'] = $reader->getReachReportColumn($p->dfa_site, 'Unique Reach: Average Impression Frequency', $dfp_data);
                $d['unique_total_reach'] = $reader->getReachReportColumn($p->dfa_site, 'Unique Reach: Total Reach', $dfp_data);

                $data_for_table[] = $d;
            }

            $this->sites = $data_for_table;
        }


    }
    public function render()
    {
        return view('livewire.hcp-dashboard-utm-by-site');
    }
}
