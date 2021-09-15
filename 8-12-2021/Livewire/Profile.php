<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Profile extends Component
{
    public $user;
    public $visible = false;

    public function render()
    {
        return view('livewire.profile');
    }

    public function mount($user)
    {
        $this->user = $user;
    }
}
