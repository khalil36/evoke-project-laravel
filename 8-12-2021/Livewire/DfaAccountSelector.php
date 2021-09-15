<?php

namespace App\Http\Livewire;

use App\Google\Services\Analytics\DfaReader;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use function PHPUnit\Framework\isNull;

class DfaAccountSelector extends Component
{
    public $advertisers;

    public $advertiserId;

    public $isDisabled = false;

    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    private $reader = null;

    public function mount(DfaReader $reader, $team){

        $this->team = $team;
        $this->reader = $reader;
        $this->advertisers = $reader->listAdvertisers();

        $this->displayFormatting($this->advertisers);

        if($team->dfa_advertiser_id)
            $this->advertiserId = $team->dfa_advertiser_id;

    }

    public function addDfaAccount(){
        if(!is_null($this->advertiserId))
            $this->team->dfa_advertiser_id = $this->advertiserId;
        else
            $this->team->dfa_advertiser_id = 0;
        $this->team->update();
        $this->emit("saved");
    }
    public function updatedAdvertiserId(){
        $this->isDisabled = true;
    }

    public function displayFormatting(&$list){
        foreach ($list as &$item) {
            $item['name'] = $item->name . " [" . $item->id . "]";
        }
    }
    public function render()
    {
        return view('livewire.dfa-account-selector');
    }
}
