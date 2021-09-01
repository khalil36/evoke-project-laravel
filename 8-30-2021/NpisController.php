<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NPIsImportRequest;
use App\Models\CsvFile;
use App\Models\Npis;
use App\Models\Team;
use DB, Auth, user, Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Imports\NPIsImport;
use Spatie\SimpleExcel\SimpleExcelReader;

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
    public function importNPIs()
    {
        $campaigns_created = false;
        $dfa_campaigns_created = Team::find(Auth::user()->current_team_id);
        if ($dfa_campaigns_created->dfa_campaigns_created) {
            $campaigns_created = true;
        }
        return view('npis.import_npis_new', compact('campaigns_created'));
    }

    /**
     * Show the NPIs mapping screen.
     * @return \Illuminate\View\npis\import_fields
    */
    public function mapNPIs(NPIsImportRequest $request)
    {

        $csv_data = '';
        $extension = $request->file('csv_file')->extension();
        $file_name = $request->file('csv_file')->store('uploads', 'public');

        $connection = SimpleExcelReader::create(storage_path('app/public/'.$file_name));
        $headers = $connection->getHeaders();
        $rows = $connection->take(2)->getRows();

        $csv_data = array_merge([$headers],$rows->toArray());

        DB::table('csv_file')->truncate();
        $csv_data_file = CsvFile::create([
           'csv_filename' => $file_name,
           'csv_data' => $extension,
           'data_import_type' => $request->import_option,
        ]);


        $npis_fields = Npis::getColumns();
        return view('npis.import_fields', compact('csv_data', 'csv_data_file', 'npis_fields'));

    }

    /**
     * Show the NPIs import screen.
     * @return \Illuminate\View\npis\import_npis
     */
    public function processImport(Request $request)
    {
      
        $selected_values = array(); 
        $npi_column_index = ''; 
        $first_name_column_index = ''; 
        $last_name_column_index = ''; 
        $email_column_index = ''; 
        $decile_column_index = ''; 
        $current_team_id = Auth::user()->current_team_id;
        $current_user_id = Auth::user()->id;
        $created_at = $updated_at = date('Y-m-d H:i:s');

        $file_has_column_header = $request->data_has_column_headers;
        
        foreach ($request->fields as $index =>$value) {
            
            if ($value == 'not_selected') continue;

            switch ($value) {
                case 'npi':
                    $npi_column_index = $index;
                    break;
                case 'first_name':
                    $first_name_column_index = $index;
                    break;
                case 'last_name':
                    $last_name_column_index = $index;
                    break;
                case 'email':
                    $email_column_index = $index;
                    break;
                case 'decile':
                    $decile_column_index = $index;
                    break;
            }
            
        }

        $selected_values = array_unique($request->fields);

        $csvfile_data = CsvFile::find($request->csv_data_file_id);        
        $extension = $csvfile_data->csv_data;
        $filename = $csvfile_data->csv_filename;
        $data_import_type = $csvfile_data->data_import_type;

        $use_data = array(
            'npi_column_index' => $npi_column_index, 
            'first_name_column_index' => $first_name_column_index,
            'last_name_column_index' => $last_name_column_index,
            'email_column_index' => $email_column_index,
            'decile_column_index' => $decile_column_index, 
            'current_team_id' => $current_team_id,
            'current_user_id' => $current_user_id,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        );

        DB::connection()->disableQueryLog();

        $connection = SimpleExcelReader::create(storage_path('app/public/'.$filename));
        if (empty($file_has_column_header)){
            $connection->noHeaderRow();
        }


        if ($data_import_type == 'delete') {
           Npis::where('team_id', $current_team_id)->delete();
        }

        if ($data_import_type == 'overwrite') {

            $chunks = $connection->getRows()
            ->unique(function (array $row) use ($npi_column_index) {
                $new_row = array_values($row);
                return $new_row[$npi_column_index];
            })
            ->map(function (array $row) use ($use_data){

                $new_row = array_values($row);

                $first_name_column = ''; 
                $last_name_column = ''; 
                $email_column = ''; 
                $decile_column = ''; 

                if (isset($new_row[$use_data['first_name_column_index']])) {
                    $first_name_column = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (string)$new_row[$use_data['first_name_column_index']]);
                }
                if (isset($new_row[$use_data['last_name_column_index']])) {
                    $last_name_column = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (string)$new_row[$use_data['last_name_column_index']]);
                }
                if (isset($new_row[$use_data['email_column_index']])) {
                    $email_column = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (string)$new_row[$use_data['email_column_index']]);
                }
                if (isset($new_row[$use_data['decile_column_index']])) {
                    $decile_column = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (string)$new_row[$use_data['decile_column_index']]);
                }
            
                return [
                    'npi' => $new_row[$use_data['npi_column_index']],
                    'first_name' => $first_name_column,
                    'last_name' => $last_name_column,
                    'email'=> $email_column,
                    'decile'=> $decile_column,
                    'team_id' => $use_data['current_team_id'],
                    'created_by_user_id' => $use_data['current_user_id'],
                    'created_at' => $use_data['created_at'],
                    'updated_at' => $use_data['updated_at']
                ];
            })
            ->chunk(1000)
            ->each(function ( \Illuminate\Support\LazyCollection $chunk) {
                Npis::upsert($chunk->toArray(), ['npi', 'team_id']);
            });

        } else {

            $chunks = $connection->getRows()
            ->unique(function (array $row) use ($npi_column_index) {
                $new_row = array_values($row);
                return $new_row[$npi_column_index];
            })
            ->reject(function (array $row) use ($use_data){

                $new_row = array_values($row);
                return ( !empty(Npis::where(['npi' => $new_row[$use_data['npi_column_index']], 'team_id' => $use_data['current_team_id']])->first()));

            })
            ->map(function (array $row) use ($use_data){

                $new_row = array_values($row);

                $first_name_column = ''; 
                $last_name_column = ''; 
                $email_column = ''; 
                $decile_column = ''; 

                if (isset($new_row[$use_data['first_name_column_index']])) {
                    $first_name_column = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (string)$new_row[$use_data['first_name_column_index']]);
                }
                if (isset($new_row[$use_data['last_name_column_index']])) {
                    $last_name_column = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (string)$new_row[$use_data['last_name_column_index']]);
                }
                if (isset($new_row[$use_data['email_column_index']])) {
                    $email_column = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (string)$new_row[$use_data['email_column_index']]);
                }
                if (isset($new_row[$use_data['decile_column_index']])) {
                    $decile_column = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', (string)$new_row[$use_data['decile_column_index']]);
                }
            
                 return [
                    'npi' => $new_row[$use_data['npi_column_index']],
                    'first_name' => $first_name_column,
                    'last_name' => $last_name_column,
                    'email'=> $email_column,
                    'decile'=> $decile_column,
                    'team_id' => $use_data['current_team_id'],
                    'created_by_user_id' => $use_data['current_user_id'],
                    'created_at' => $use_data['created_at'],
                    'updated_at' => $use_data['updated_at']
                ];
            })
            ->chunk(1000)
            ->each(function ( \Illuminate\Support\LazyCollection $chunk, $i) use ($npi_column_index, $current_team_id) {

                DB::table('npis')->insert($chunk->toArray());

            });
            
        }
        unlink(storage_path('app/public/'.$filename));
        return redirect('/npis')->with('success', 'NPIs Data imported successfully.');

        
    }
}
