<?php

namespace App\Http\Controllers;

// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\MediaPartnerULDImport;
use DB;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\MediaPartnerULD;
use App\Models\Npis;


class AsifController extends Controller
{
 public function test(){
    ini_set('max_execution_time', '0'); // for infinite time of execution 
    DB::connection()->disableQueryLog();
    $time_start = microtime(true); 
   $pathToCsv = 'npis_users.csv';
    // $pathToCsv = 'test_90mb.csv';
    // $pathToCsv = 'test_90mb.xlsx';
    // $pathToCsv = 'test_100k_rows.csv';
    
    $connection = SimpleExcelReader::create($pathToCsv);

    $first_line_is_header =  false;
    if($first_line_is_header){
      $headers = $connection->getHeaders();
    }
    else{
      $connection->noHeaderRow();
    }

    $chunks = $connection->getRows()
    // ->reject(function (array $row){
    //     $new_row = array_values($row);
    //     //$new_row = array_unique($new_row);
    //     return ( !empty(Npis::where(['npi' => $row[1], 'team_id' => 2])->first()));
    // })
    ->unique(1)->pluck(1);
    dd($chunks->all());
    $connection->reject(function (array $row){
        $new_row = array_values($row);
        //$new_row = array_unique($new_row);
        //return $chunk->unique('npi');
        return ( !empty(Npis::where(['npi' => $new_row[1], 'team_id' => 2])->first()));
    })
    ->map(function (array $row) {
     // $new_row = array_values($row);
      return [
        'npi' => $row[1],
        // 'first_name' => 'bbb',
        // 'last_name' => 'aaa',
        'first_name' => preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row[2]),
        'last_name' => preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row[3]),
        'email'=>'asif@creatingdigital.com',
        'decile'=>'abcdef',
        'team_id' => 2,
        'created_by_user_id' => 1
      ];
    })
    ->chunk(1000)
   
    ->each(function ( \Illuminate\Support\LazyCollection $chunk, $i) {
        // echo $i.' - '.count($chunk->toArray());
        // echo '<br>';
        //Npis::upsert($chunk->toArray(), ['npi', 'team_id']);
        // $date
       // $data = $chunk->unique()->toArray();
        //dd($data);
        // $data = array_unique($data);
        DB::table('npis')->insert($chunk->toArray());
    });

    // dd($chunks->all());

    $time_end = microtime(true);
    $execution_time = ($time_end - $time_start);
    echo '<b>Total Execution Time:</b> '.($execution_time*1000);

exit;
    $file_npis = $connection->getRows()->pluck(1)->all();
    
    // dd( $file_npis );
    $already_exist  = Npis::where("team_id", 2)->cursor()->filter(function ($npi) use($file_npis) {
      return in_array($npi->npi, $file_npis);
    })->pluck('npi');

    dump($already_exist->all());

    // $connection
    //   ->getRows()
    //   ->each(function($row){
    //   });
    // $date_column_field = 6;
    // $rows = $connection
    //   // ->take(2)
    //   ->noHeaderRow()
    //   ->getRows()
    //   ->filter(function($row, $i) use ($date_column_field){
    //     $new_row = array_values($row);
    //     return ("object" != gettype($new_row[$date_column_field]));
    //     // dump(array_values($row));
    //     // return true;
    //     // return (gettype( $row["DATE"] ) != "object");
    //     // dump($row["DATE"]);
    //   });

      // dump($rows->count());
    // if($rows->count()==0){
    //   $rows = $connection
    //   // ->take(2)
    //   ->getRows()
    //   ->each(function($row, $i){
    //     dump()
    //     //insert into database
    //     // return (gettype( $row["DATE"] ) != "object");
    //     // dump($row["DATE"]);
    //   });
    // }

    
    // dd(array_merge([$headers], $rows->toArray()) );
 }
}