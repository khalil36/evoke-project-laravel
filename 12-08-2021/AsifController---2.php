<?php

namespace App\Http\Controllers;

// use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\MediaPartnerULDImport;
use Spatie\SimpleExcel\SimpleExcelReader;

class AsifController extends Controller
{
 public function test(){

    $rows = SimpleExcelReader::create('npis_users.csv')
    ->take(3)
    ->getRows()
    ->each(function(array $rowProperties) {
        echo '<pre>';
        var_dump($rowProperties);
        echo '</pre>';

    });
 }   
}