<?php

namespace App\Http\Controllers;

// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\MediaPartnerULDImport;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\MediaPartnerULD;

class AsifController extends Controller
{
 public function test(){
    $pathToCsv = 'npis_users.xlsx';
    $connection = SimpleExcelReader::create($pathToCsv);
    $headers = $connection->getHeaders();

    $rows = $connection
      // ->take(2)
      ->getRows()
      ->filter(function($row, $i){
        return (gettype( $row["DATE"] ) != "object");
        // dump($row["DATE"]);
      });
    if($rows->count()==0){
      $rows = $connection
      // ->take(2)
      ->getRows()
      ->each(function($row, $i){
        dump()
        //insert into database
        // return (gettype( $row["DATE"] ) != "object");
        // dump($row["DATE"]);
      });
    }

    
    // dd(array_merge([$headers], $rows->toArray()) );
 }
}