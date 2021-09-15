<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Notifications\ImportedMediaPartnerULD;
use App\Notifications\FailedMediaPartnerULDImport;
use App\Models\MediaPartnerULD;
use App\Models\CsvFile;
use App\Models\MediaPartner;
use App\Models\User;
use DB, Log;


class ImportMediaPartnerULD implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 80000;
    
    public $selected_values;
    public $file_has_column_header;
    public $csv_data_file_id;
    public $user_id;

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

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $user = User::find($this->user_id);
        $csvfile_data = CsvFile::find($this->csv_data_file_id);
        $media_partner_id = $csvfile_data->media_partner_id;
        $media_partner = MediaPartner::find($media_partner_id);
        $extension = $csvfile_data->csv_data;
        $filename = $csvfile_data->csv_filename;
        $data_import_type = $csvfile_data->data_import_type;
        $date_column_index = false; 
        $npi_column_index = false; 
        $created_at = $updated_at = date('Y-m-d H:i:s');

        DB::connection()->disableQueryLog();

        foreach ($this->selected_values as $index => $field) {
           if ($field == 'not_selected') continue;

           if ($field == 'npi') {
              $npi_column_index =  $index; 
           } elseif ($field == 'date' && $extension == 'xlsx') {
               $date_column_index = $index; 
           } else {
               if ($field == 'date') {
                   $date_column_index = $index; 
               }
           }
        }

        $connection = SimpleExcelReader::create(storage_path('app/public/'.$filename));
        if (empty($this->file_has_column_header)){
           $connection->noHeaderRow();
        }

        $row = $connection
           ->getRows()
           ->first(function($row) use ($date_column_index, $extension){

               $new_row = array_values($row);
   
               if ($extension == 'csv') {
                   return (false === strtotime($new_row[$date_column_index]));
               } else {
                   if (gettype( $new_row[$date_column_index] ) != "object") {
                       if (false === strtotime($new_row[$date_column_index])) {
                           return true;
                       } else {
                           return false;
                       }
                   }
               }
               
        });

        if($row){

            $user->notify(new FailedMediaPartnerULDImport($row, $media_partner->media_partner_name));

        } else {
           
            if ($data_import_type == 'delete') {
               MediaPartnerULD::where('media_partner_id', $media_partner_id)->delete();
            }

            $chunks = $connection->getRows()
            ->map(function (array $row) use ($extension, $date_column_index, $npi_column_index, $media_partner_id, $created_at, $updated_at){

               $new_row = array_values($row);

               if ($extension == 'xlsx') {
                   if (gettype( $new_row[$date_column_index]) == 'object') {
                       $date = $new_row[$date_column_index]->format('Y-m-d H:i:s');
                   } else {
                       $date = date('Y-m-d H:i:s', strtotime($new_row[$date_column_index]));
                   }
               } else {
                   $date = date('Y-m-d H:i:s', strtotime($new_row[$date_column_index]));
               }
           
               return [
                   'npi' => $new_row[$npi_column_index],
                   'date' => $date,
                   'media_partner_id' => $media_partner_id,
                   'created_at' => $created_at,
                   'updated_at' => $updated_at
                  
               ];
            })
            ->chunk(1000)
            ->each(function ( \Illuminate\Support\LazyCollection $chunk) {
               DB::table('media_partner_uld')->insert($chunk->toArray());
            });

            $user->notify(new ImportedMediaPartnerULD($media_partner->media_partner_name));
        }

        unlink(storage_path('app/public/'.$filename));
    }

}
