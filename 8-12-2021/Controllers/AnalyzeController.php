<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyzeController extends Controller
{
    /**
     * Show the analyze screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('analyze.index');


    }
}
