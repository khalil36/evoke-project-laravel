<?php

namespace App\Http\Controllers;

// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\MediaPartnerULDImport;
use Spatie\SimpleExcel\SimpleExcelReader;

class AsifController extends Controller
{
 public function test(){
    $pathToCsv = 'test_90mb.csv';
    $connection = SimpleExcelReader::create($pathToCsv);
    $headers = $connection->getHeaders();

    echo '<pre>';
    var_dump($headers);
    echo '</pre>';

    $rows = $connection
    // ->take(100)
    ->getRows()
    ->each(function(array $rowProperties, $i) {
        echo $i;
        // echo '<br/>';
        // $skip = $skip+2;
        // $model->insert($rowProperties);
        // echo '<pre>';
        // var_dump($rowProperties);
        // echo '</pre>';
        // echo '------------';
    });
 }   
}