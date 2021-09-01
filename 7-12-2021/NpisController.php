<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NPIsImportRequest;
use App\Models\CsvFile;
use App\Models\Npis;
use DB, Auth, user, Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Imports\NPIsImport;

class NpisController extends Controller
{
    /**
     * Show the NPIs screen.
     * @return \Illuminate\View\npis\index
     */
    public function index()
    {

        $npis = DB::table('npis')
                    ->select('npis.*', 'users.name')
                    ->orderBy('npis.id','DESC')
                    ->join('users', 'users.id', '=', 'npis.created_by_user_id')
                    ->where('npis.team_id', Auth::user()->current_team_id)
                    ->paginate(5);
        return view('npis.index', compact('npis'));
    }

    /**
     * Show the NPIs import screen.
     * @return \Illuminate\View\npis\import_npis
     */
    public function import_npis()
    {
        return view('npis.import_npis');
    }

    /**
     * Show the NPIs import screen.
     * @return \Illuminate\View\npis\import_npis
     */
    public function importNPIs()
    {
        return view('npis.import_npis_new');
    }

    /**
     * Show the NPIs mapping screen.
     * @return \Illuminate\View\npis\import_fields
    */
    public function mapNPIs(NPIsImportRequest $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $extension = $request->file('csv_file')->extension();

        if ($extension == 'csv') {
            $data = array_map('str_getcsv', file($path));
        } else{
            
            $csv_data = Excel::toArray(new NPIsImport, $request->file('csv_file'));

            if(!empty($csv_data)){
              // echo "<pre>"; print_r($csv_data); 
               foreach ($csv_data as $key => $value) {
                   if(!empty($value)){
                       foreach ($value as $v) {        
                           $data[] = $v;
                       }
                   }
               }
               //echo "after loop : <pre>"; print_r($data); exit();
           }
        }

        $csv_data_file = CsvFile::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);

        $csv_data = array_slice($data, 0, 3);

        $npis_fields = Npis::getColumns();
        return view('npis.import_fields', compact('csv_data', 'csv_data_file', 'npis_fields'));

    }

    /**
     * Show the NPIs import screen.
     * @return \Illuminate\View\npis\import_npis
     */
    public function processImport(Request $request)
    {
        
        $selected_values = array(); $npi = '--';
        //$temp_arr = $request->fields;
        $selected_values = array_unique($request->fields);
        echo "before unset<pre>"; print_r(array_unique($selected_values));
        //exit();

        $pos = array_search('not_seclected', $selected_values);

        echo 'not : ' . $pos . ' ==132';

        // Remove from array
        unset($selected_values[$pos]);

        //print_r($hackers);

        // if (($key = array_search(-1, $selected_values)) !== false) {
        //     unset($selected_values[$key]);
        // }
        echo "after undset<pre>"; print_r($selected_values);
       // exit();
        // foreach ($temp_arr as $index => $field) {
        //     if (isset($temp_arr[$index])) {
        //         $temp_arr[$index] = $field;
        //     }
        // }

        // echo "after seting value<pre>"; print_r(array_unique($temp_arr));
        

        // foreach ($request->fields as $value) {

        //     if ($value == -1) continue;

        //     // foreach (config('app.db_fields') as $index => $field) {
        //     //     if ($field != 'NPI') continue;
        //     //     $npi_index = $index;
        //     // }

        //     $index_array [] = $value;
        // }

        if (count($selected_values) > 5) {
           return redirect('/importNPIs')->with('Error', 'Please select only five fields.');
        }
       
        //  echo "<pre>"; print_r($index_array);
        // echo '<br>';
       // exit();
        $data = CsvFile::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        $count = 0; $existing_npis = array();

        // foreach ($csv_data as $index => $value) {
        //     if (!empty($value)) {
        //         echo "<pre>";print_r($value);
        //         echo '<br>';
        //     }
        // }
        //echo "before:<pre>"; print_r($csv_data); 
        // echo '<br>';
        // echo "After<pre>";print_r(array_filter($csv_data));
        // echo "After<pre>";print_r(array_filter($csv_data, fn($value) => !is_null($value) && $value !== ''));

        //exit();

        foreach ($csv_data as $row) {
            //echo "<pre>"; print_r($row); 
            if ($count > 0) {
    
                // $existing_npi = DB::table('npis')
                //                     ->select('npis.npi')
                //                     ->where('npi', $row[$npi_index])
                //                     ->where('team_id', Auth::user()->current_team_id)
                //                     ->first();

                // if ($existing_npi) {
                //     $existing_npis[] = $existing_npi->npi;
                //     continue;

                // } else {

                    $npis = new Npis();
                    foreach ($selected_values as $index => $field) {
                    //foreach ($temp_arr as $index => $field) {
                       //echo 'index_array: '.$index_array[$index]; exit();
                        $npis->$field = $row[$index];
                    }

                    $npis->team_id = Auth::user()->current_team_id;
                    $npis->created_by_user_id = Auth::user()->id;
                    $npis->save();
                //}

            }

            $count++;
        }
        if ($existing_npis) {
            Session::flash('existing_npis', array_unique($existing_npis));
        }
        return redirect('/npis')->with('success', 'Data imported successfully.');

    }
     /**
     * Show the NPIs search screen.
     * @return \Illuminate\View\npis\index
     */
    public function searchNPIs(Request $request)
    {
        $validated = $request->validate([
            'search_npis' => 'required'
        ]);
        $npis = DB::table('npis')
                ->select('npis.*', 'users.name')
                ->orderBy('npis.id','DESC')
                ->join('users', 'users.id', '=', 'npis.created_by_user_id')
                ->where('npis.team_id', Auth::user()->current_team_id)
                ->Where('npis.'.$request->search_npis_option, 'LIKE', '%' . $request->search_npis . '%')
                ->paginate(5);

        $messages = array(
            'search_option' => $request->search_npis_option,
            'search_text' => $request->search_npis
        );    
        return view('npis.index', compact('npis', 'messages'));
    }
}
