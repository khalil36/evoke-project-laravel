<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ValidateMediaPartner;
use App\Models\MediaPartner;
use DB, Auth, User, Session;

class MediaPartnerController extends Controller
{

    /**
     * Show the Media Partners screen.
     * @return \Illuminate\View\media_partners\index
     */
    public function index()
    {

        $media_partners = DB::table('media_partners')
                        ->select('media_partners.*', 'users.name')
                        ->orderBy('media_partners.id','DESC')
                        ->join('users', 'users.id', '=', 'media_partners.created_by_user_id')
                        ->where('media_partners.team_id', Auth::user()->current_team_id)
                        ->paginate(5);

        return view('media-partners.index', compact('media_partners'));
    }

    /**
     * Show the Media Partner screen.
     * @return \Illuminate\View\media_partners\create
     */
    public function create()
    {
        return view('media-partners.create');
    }

    /**
     * Save the Media Partner name.
     * @return \Illuminate\View\media_partners\create
     */
    public function save(ValidateMediaPartner $request)
    {
        MediaPartner::create([
            'media_partner_name' => $request->media_partner_name,
            'team_id' => Auth::User()->current_team_id,
            'created_by_user_id' => Auth::User()->id,
        ]);

        return redirect('/media-partners/create')->with('Success', 'Media partner name has been saved successfully.');;

    }
}
