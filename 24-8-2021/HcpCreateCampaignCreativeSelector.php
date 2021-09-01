<?php

namespace App\Http\Livewire;

use App\Google\Services\Analytics\DfaReader;
use App\Jobs\ProcessDFACampaignCollection;
use App\Jobs\ProcessDFACampaignSetup;
use App\Models\Npis;
use App\Models\Team;
use App\Models\VirtualDFAAd;
use App\Models\VirtualDFACampaign;
use App\Models\VirtualDFACreative;
use App\Models\VirtualDFAPlacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class HcpCreateCampaignCreativeSelector extends Component
{
    public $confirmingCreativeIsSelected = false;

    public $allCreatives;

    public $creatives=[];

    public $isDisabled = false;

    public function mount(DfaReader $reader, Team $team){
        $this->allCreatives = $reader->listCreatives($team);

    }

    public function render()
    {
        $this->mount(App::make(DfaReader::class), Auth::user()->currentTeam);
        return view('livewire.hcp-create-campaign-creative-selector');
    }

    public function updatedCreatives($creatives):void{
        $this->creatives = $creatives;

        if(count($creatives) > 0 )
            $this->isDisabled = true;
        else
            $this->isDisabled = false;
    }

    public function create(Request $request, DfaReader $reader)
    {


        $this->resetErrorBag();

        ProcessDFACampaignCollection::dispatch(Auth::user()->currentTeam, $this->creatives);

        session()->flash('success', 'We have scheduled the campaigns to be automatically created.');

        return redirect()->to("/hcp/create-campaigns");
    }
}
