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
    public function index(Request $request)
    {
       
        if (!empty($_GET['search_npis'])) {
            
            $npis = DB::table('npis')
                    ->select('npis.*', 'users.name')
                    ->orderBy('npis.id','DESC')
                    ->join('users', 'users.id', '=', 'npis.created_by_user_id')
                    ->where('npis.team_id', Auth::user()->current_team_id)
                    ->Where('npis.'.$request->search_npis_option, 'LIKE', '%' . $request->search_npis . '%')
                    ->paginate(10);
        } else {

            $npis = DB::table('npis')
                    ->select('npis.*', 'users.name')
                    ->orderBy('npis.id','DESC')
                    ->join('users', 'users.id', '=', 'npis.created_by_user_id')
                    ->where('npis.team_id', Auth::user()->current_team_id)
                    ->paginate(10);
        }

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
            
               foreach ($csv_data as $key => $value) {
                   if(!empty($value)){
                       foreach ($value as $v) {        
                           $data[] = $v;
                       }
                   }
               }
           }
        }

        $csv_data_file = CsvFile::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data),
            'data_import_type' => $request->import_option
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
      
        $selected_values = $number_of_values =  array(); 
        $npi_index = ''; $count = 0;
       // echo "1:<pre>"; print_r($request->fields); 
        foreach ($request->fields as $index =>$value) {
            if ($value == 'not_seclected') continue;
            $number_of_values[] = $value;

            if ($value == 'npi')
              $npi_index = $index;
        }

        if ($npi_index == '') {
            return redirect('/importNPIs')->with('Error', '"NPI" is a required field, please select "NPI" from any dropdown');
        }
       // echo "2. index npis: ". $npi_index;
       // exit();
        $duplicate_values = array();
        foreach(array_count_values($number_of_values) as $val => $c)
            if($c > 1) $duplicate_values[] = $val;

        if ($duplicate_values) {
        
            Session::flash('duplicate_values', array_unique($duplicate_values));
            return redirect('/importNPIs')->with('Error', 'You have selected duplicate fields. Below are the duplicated fields.');
        } 

        $selected_values = array_unique($request->fields);
      
        $data = CsvFile::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);

        switch ($data->data_import_type) {
            case 'merge':

                foreach ($csv_data as $row) {
                    if ($count > 0) {
                        $existing_npi = Npis::where(['npi' => $row[$npi_index], 'team_id' =>Auth::user()->current_team_id])->first();
                        if (empty($existing_npi)) {

                            $npis = new Npis();
                            foreach ($selected_values as $index => $field) {
                                if ($field == 'not_seclected') continue;
                                if (isset($row[$index])) {
                                    $npis->$field = strip_tags($row[$index]);
                                } else {
                                    $npis->$field = null;
                                }
                            }

                            $npis->team_id = Auth::user()->current_team_id;
                            $npis->created_by_user_id = Auth::user()->id;
                            $npis->save();
                        }

                    }

                    $count++;
                }
                
                break;
            
            case 'overwrite':

                foreach ($csv_data as $row) {
                    if ($count > 0) {
                        
                        $existing_npi = Npis::where(['npi' => $row[$npi_index], 'team_id' =>Auth::user()->current_team_id])->first();

                        if (!empty($existing_npi)) {

                            $existing_npi_2 = Npis::find($existing_npi->id);
                            //echo 'existing_npi_2:<pre>';print_r($existing_npi_2->getFillable());echo'<br>';
                            foreach ($existing_npi_2->getFillable() as $index => $value){
                                if ($value == 'team_id' or $value == 'created_by_user_id') continue;
                                if (!in_array($value, $selected_values)){
                                    $empty_fields[] =  $value; 
                                }
                            }

                           // echo 'empty_fields:<pre>';print_r($empty_fields); exit();
                            foreach ($selected_values as $index => $field) {
                                if ($field == 'not_seclected') continue;
                                $existing_npi_2->$field = strip_tags($row[$index]);
                            }

                            if (!empty($empty_fields)) {
                                foreach ($empty_fields as $index => $field) {
                                    $existing_npi_2->$field = null;
                                }
                            }

                            $existing_npi_2->team_id = Auth::user()->current_team_id;
                            $existing_npi_2->created_by_user_id = Auth::user()->id;
                            $existing_npi_2->save();

                            

                        } else {

                            $npis = new Npis();
                            foreach ($selected_values as $index => $field) {
                                if ($field == 'not_seclected') continue;
                                $npis->$field = strip_tags($row[$index]);
                            }

                            $npis->team_id = Auth::user()->current_team_id;
                            $npis->created_by_user_id = Auth::user()->id;
                            $npis->save();
                        }

                    }

                    $count++;
                }
                break;

            case 'delete':

                Npis::where('team_id', Auth::user()->current_team_id)->delete();
                foreach ($csv_data as $row) {
                    if ($count > 0) {

                        $npis = new Npis();
                        foreach ($selected_values as $index => $field) {
                            if ($field == 'not_seclected') continue;
                            $npis->$field = strip_tags($row[$index]);
                        }

                        $npis->team_id = Auth::user()->current_team_id;
                        $npis->created_by_user_id = Auth::user()->id;
                        $npis->save();

                    }

                    $count++;
                }

                break;
        }

        return redirect('/npis')->with('success', 'Data imported successfully.');

    }
     /**
     * Show the NPIs search screen.
     * @return \Illuminate\View\npis\index
     */
    // public function searchNPIs(Request $request)
    // {
    //     $validated = $request->validate([
    //         'search_npis' => 'required'
    //     ]);
    //     $npis = DB::table('npis')
    //             ->select('npis.*', 'users.name')
    //             ->orderBy('npis.id','DESC')
    //             ->join('users', 'users.id', '=', 'npis.created_by_user_id')
    //             ->where('npis.team_id', Auth::user()->current_team_id)
    //             ->Where('npis.'.$request->search_npis_option, 'LIKE', '%' . $request->search_npis . '%')
    //             ->paginate(5);
    //       //  echo "<pre>"; print_r($npis);
    //     $messages = array(
    //         'search_option' => $request->search_npis_option,
    //         'search_text' => $request->search_npis
    //     );    
    //     return view('npis.index', compact('npis', 'messages'));
    // }
}
