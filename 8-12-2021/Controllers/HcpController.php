<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HcpController extends Controller
{
    /**
     * Show the HCP screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('hcp.index',
            [ 'team' => Auth::user()->currentTeam ]
        );


    }
}
