<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Google\Services\Analytics\AnalyticsReader;
use Illuminate\Support\Facades\App;

class GoogleAnalyticsViewSelector extends Component
{
    public $accounts;
    public $properties;
    public $views;

    public $accountId;
    public $propertyId;
    public $viewId;

    public $isDisabled = false;

    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    private $reader = null;

    public function mount(AnalyticsReader $reader, $team){

        $this->team = $team;
        $this->reader = $reader;
        $this->accounts = $reader->getAccounts();
        if($team->ga_account_id > 0) {
            $this->accountId = $team->ga_account_id;

            $this->properties = $reader->getProperties($this->accountId);
            $this->displayFormatting($this->properties);
            $this->propertyId = $team->ga_property_id;

            $this->views = $reader->getViews($this->accountId, $this->propertyId);
            $this->displayFormatting($this->views);
            $this->viewId = $team->ga_view_id;
        }

    }

    public function render()
    {
        return view('livewire.google-analytics-view-selector');
    }

    public function updatedAccountId($id): void{

        if($id > 0) {
            $reader = App::make(AnalyticsReader::class);

            $this->properties = $reader->getProperties($this->accountId);

            $this->displayFormatting($this->properties);
        }else{
            $this->isDisabled = true;
        }
        $this->viewId = null;
        $this->propertyId = null;

        $this->emitSelf('property-updated', $this->properties);
    }

    public function updatedPropertyId($id): void{

        if($id > 0) {
            $reader = App::make(AnalyticsReader::class);

            $this->views = $reader->getViews($this->accountId, $this->propertyId);

            $this->viewId = null;

            $this->isDisabled = false;

            $this->displayFormatting($this->views);
        }else{
            $this->viewId = null;
        }
        $this->emitSelf('view-updated', $this->views);
    }

    public function updatedViewId($id): void{
        if($id > 0)
            $this->isDisabled = true;
        else
            $this->isDisabled = false;
    }
    public function addGAView(){
        if(is_null($this->accountId)){
            $this->team->ga_account_id = 0;
            $this->team->ga_property_id = 0;
            $this->team->ga_view_id = 0;
        }else {
            $this->team->ga_account_id = $this->accountId;
            $this->team->ga_property_id = $this->propertyId;
            $this->team->ga_view_id = $this->viewId;
        }
        $this->team->update();
        $this->emit("saved");
    }

    public function displayFormatting(&$list){
        foreach ($list as &$item) {
            $item['name'] = $item->getName() . " [" . $item->getId() . "]";
        }
    }
}
