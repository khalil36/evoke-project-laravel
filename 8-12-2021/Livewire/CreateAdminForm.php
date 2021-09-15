<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\User;

class CreateAdminForm extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    public $name;

    public $email;

    protected $rules = [
        'name' => 'required|max:40',
        'email' => 'required|email|unique:users',
    ];


    public function createAdmin()
    {
        $this->resetErrorBag();

        $data = $this->validate();
        $data['password'] = Hash::make(sha1(time()));
        $data['email_verified_at'] = Carbon::now()->toDateTimeString();
        $user = User::create($data);
        $user->assignRole('administrator');
        $user->sendAdminInvitedNotification(app('auth.password.broker')->createToken($user));

        session()->flash('flash.banner', 'New administrator ('.$data['email'].') has been added.');
        return $this->redirect('/admin');

    }

    public function render()
    {
        return view('livewire.create-admin-form');
    }
}
