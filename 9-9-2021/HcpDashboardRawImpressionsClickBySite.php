<?php

namespace App\Http\Livewire;

use App\Google\Services\Analytics\DfaReader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Helpers\Helpers;

class HcpDashboardRawImpressionsClickBySite extends Component
{
    public $start_date;

    public $end_date;

    public $sites = [];

    public $readyToLoad = false;

    //we may need to change this to fire off a method that has a date parameter
    protected $listeners = ['dateChanged' => 'dateChanged'];

    public function loadSites(DfaReader $reader){
        $this->readyToLoad = true;
        $this->mount(App::make(DfaReader::class), Auth::user()->currentTeam);

    }

    public function dateChanged($dates, DfaReader $reader){
        $this->start_date = $dates['start_date'];
        $this->end_date = $dates['end_date'];
        $this->mount($reader, Auth::user()->currentTeam);

    }

    public function mount(DfaReader $reader, $team){

        if (empty($this->end_date) && empty($this->start_date)) {
            $dates = Helpers::getHcpInitialDates($team->id);
            $this->start_date = $dates['start_date'];
            $this->end_date = $dates['end_date'];
        }

        if($this->readyToLoad) {
            $data = $reader->getRawImpressionsClicksBySite(Auth::user()->currentTeam, $this->start_date, $this->end_date);
            $sites = [];

            if($data) {
                $partners = $team->mediaPartners()->get();
                foreach ($partners as $p) {
                    foreach ($data as $d) {
                        if ($d['Site (CM360)'] == $p->dfa_site) {
                            $sites[] = $d;
                        }
                    }
                }
            }

            $this->sites = $sites;
        }


    }
    public function render(DfaReader $reader)
    {
        return view('livewire.hcp-dashboard-raw-impressions-click-by-site',['sites' => $this->sites]);
        /*return view('livewire.hcp-dashboard-raw-impressions-click-by-site', [
            'sites' => $this->readyToLoad
                ? $reader->getRawImpressionsClicksBySite(Auth::user()->currentTeam, $this->start_date, $this->end_date)
                : [],
        ]);*/
    }
}
