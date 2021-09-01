<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MediaPartner;
use Illuminate\Http\Request;
use Session;

class DeleteMediaPartner extends Component
{


    /*
     * Indicates if media partner deletion is being confirmed.
     *
     * @var bool
    */
    public $mediaPartner;
    public $confirmingMediaPartnerDeletion = false;

    /*
     * Confirm that the media partner would like to delete their account.
     *
     * @return void
    */
    public function confirmMediaPartnerDeletion()
    {
        $this->resetErrorBag();

        $this->confirmingMediaPartnerDeletion = true;
    }
    /*
     * Confirm that the media partner would like to delete their account.
     *
     * @return void
    */
    public function deleteMediaPartner($id)
    {

        $this->resetErrorBag();
        $result = MediaPartner::where('id',$id)->delete();

        if ($result) {
            Session::flash('deleted', 'Media partner has been deleted!');
            return redirect()->to("/media-partners");
        } else {
            Session::flash('deleted', 'Error! Media partner has not been deleted!');
            return redirect()->to("/media-partners");
        }
    }

    public function render()
    {
        return view('livewire.delete-media-partner');
    }

    public function mount($mediaPartner)
    {
        $this->mediaPartner = $mediaPartner;
    }
}
