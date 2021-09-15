<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\ImportedNPIs;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\CsvFile;
use App\Models\Npis;
use App\Models\User;
use Auth, DB;

class ImportNPIs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 80000;
    
    public $selected_values;
    public $file_has_column_header;
    public $csv_data_file_id;
    public $user_id;
    public $npi_column_index; 
    public $first_name_column_index; 
    public $last_name_column_index; 
    public $email_column_index; 
    public $decile_column_index; 
    public $current_team_id;
    public $current_user_id;
    public $created_at; 
    public $updated_at;

    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct($selected_values, $file_has_column_header, $csv_data_file_id, $user_id)
    {
        $this->selected_values = $selected_values;
        $this->file_has_column_header = $file_has_column_header;
        $this->csv_data_file_id = $csv_data_file_id;
        $this->user_id = $user_id;
        $this->current_team_id = Auth::user()->current_team_id;
        $this->current_user_id = Auth::user()->id;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->selected_values as $index =>$value) {
                    
            if ($value == 'not_selected') continue;

            switch ($value) {
                case 'npi':
                    $this->npi_column_index = $index;
                    break;
                case 'first_name':
                    $this->first_name_column_index = $index;
                    break;
                case 'last_name':
                    $this->last_name_column_index = $index;
                    break;
                case 'email':
                    $this->email_column_index = $index;
                    break;
                case 'decile':
                    $this->decile_column_index = $index;
                    break;
            }
            
        }

        $csvfile_data = CsvFile::find($this->csv_data_file_id);        
        $extension = $csvfile_data->csv_data;
        $filename = $csvfile_data->csv_filename;
        $data_import_type = $csvfile_data->data_import_type;

        $use_data = array(
            'npi_column_index' => $this->npi_column_index, 
            'first_name_column_index' => $this->first_name_column_index,
            'last_name_column_index' => $this->last_name_column_index,
            'email_column_index' => $this->email_column_index,
            'decile_column_index' => $this->decile_column_index, 
            'current_team_id' => $this->current_team_id,
            'current_user_id' => $this->current_user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        );

        DB::connection()->disableQueryLog();

        $connection = SimpleExcelReader::create(storage_path('app/public/'.$filename));
        if (empty($this->file_has_column_header)){
            $connection->noHeaderRow();
        }


        if ($data_import_type == 'delete') {
           Npis::where('team_id', $this->current_team_id)->delete();
        }

        if ($data_import_type == 'overwrite') {

            $chunks = $connection->getRows()
            ->unique(function (array $row) use ($use_data) {
                $new_row = array_values($row);
                return $new_row[$use_data['npi_column_index']];
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
            ->unique(function (array $row) use ($use_data) {
                $new_row = array_values($row);
                return $new_row[$use_data['npi_column_index']];
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
            ->each(function ( \Illuminate\Support\LazyCollection $chunk) {

                DB::table('npis')->insert($chunk->toArray());

            });
            
        }

        $user = User::find($this->user_id);
        $user->notify(new ImportedNPIs());
        unlink(storage_path('app/public/'.$filename));
    }
}
