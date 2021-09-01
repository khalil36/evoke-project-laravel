<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CsvFile;
use App\Models\Npis;
use DB, Auth, user, Session;
class NpisController extends Controller
{
    /**
     * Show the NPIS screen.
     * @return \Illuminate\View\npis\index
     */
    public function index()
    {

        $npis = DB::table('npis')
                    ->select('npis.*', 'users.name')
                    ->orderBy('npis.id','DESC')
                    ->join('users', 'users.id', '=', 'npis.created_by_user_id')
                    ->get();
        return view('npis.index', compact('npis'));
    }

    /**
     * Show the NPIS import screen.
     * @return \Illuminate\View\npis\import_npis
     */
    public function import_npis()
    {
        return view('npis.import_npis');
    }

    /**
     * Show the NPIS import screen.
     * @return \Illuminate\View\npis\import_npis
     */

    public function processImport(Request $request)
    {
       
        $DB_Fields = array(
            $request->team_id =>'team_id',
            $request->npi =>'npi',
            $request->first_name =>'first_name',
            $request->last_name =>'last_name',
            $request->email =>'email',
            $request->decile =>'decile',
        );

        $data = CsvFile::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        $count = 0; $existing_team_ids = array();
        foreach ($csv_data as $row) {

            if ($count > 0) {
                $existing_npi = Npis::where(['npi'=>$row[$request->npi], 'team_id' => Auth::user()->current_team_id])->get();
                if ($existing_npi) {
                    $existing_npis[] = $existing_npi->npi;
                    continue;
                } else {

                    $npis = new Npis();

                    foreach ($DB_Fields as $index => $field) {
                        $npis->$field = $row[$index];
                    }

                    $npis->created_by_user_id = Auth::user()->id;
                    $npis->save();
                }
            }

            $count++;
        }
        if ($existing_npis) {
            Session::flash('existing_npis', array_unique($existing_npis));
        }
        return redirect('/npis')->with('success', 'Data imported successfully.');
        //return back()->with('success', 'Data imported successfully.');
    }
}
