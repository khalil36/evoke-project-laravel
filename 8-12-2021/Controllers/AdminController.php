<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $superAdmin = Role::findByName('Administrator','web');

        return view('admin.list', [
            'users' => $superAdmin->users
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request){

        //Gate::authorize('create', Jetstream::newTeamModel());

        return view('admin.create');
    }

}
