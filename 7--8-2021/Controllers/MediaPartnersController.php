<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaPartnersController extends Controller
{
    /**
     * Show the Media Partner screen.
     * @return \Illuminate\View\media_partners\create
     */
    public function create()
    {
        return view('media_partners.create');
    }
}
