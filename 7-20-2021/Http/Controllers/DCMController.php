<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ValidateImportFile;
use App\Models\CsvFile;
use App\Models\DCM;
use App\Imports\DCMDataImport;
use DB, Auth, User, Session;

class DCMController extends Controller
{

    /**
     * Show the DCMs screen.
     * @return \Illuminate\View\dcm\index
     */
    public function index()
    {
        $dcms = DCM::orderBy('id', 'DESC')->paginate(5);
        return view('dcm.index', compact('dcms'));
           
    }

    /**
    * Upload the DCM Data.
    * @return \Illuminate\View\dcm\upload_dcm_data
    */
   public function uploadDcmData()
   {
       return view('dcm.upload_dcm_data');
   }

   /**
    * Map the DCM fields.
    * @return \Illuminate\View\dcm\map_fields
   */
   public function mapDcmData(ValidateImportFile $request)
   {
       $path = $request->file('csv_file')->getRealPath();
       $extension = $request->file('csv_file')->extension();

       if ($extension == 'csv') {
           $data = array_map('str_getcsv', file($path));
       } else{
           
           $csv_data = Excel::toArray(new DCMDataImport, $request->file('csv_file'));
          // echo '<pre>'; print_r($csv_data);exit();
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
           'data_import_type' => $request->import_option,
       ]);

       $csv_data = array_slice($data, 0, 3);

       $dcm_fields = DCM::getColumns();
       return view('dcm.map_fields', compact('csv_data', 'csv_data_file', 'dcm_fields'));

   }

   /**
    * Show the DCM import screen.
    * @return \Illuminate\View\dcm\import_DCM
    */
   public function processDcmUpload(Request $request)
   {
     
       $selected_values = $number_of_values =  array(); 
       $advertiser_index = ''; $count = 0;

       foreach ($request->fields as $index =>$value) {
           if ($value == 'not_seclected') continue;
           $number_of_values[] = $value;

           if ($value == 'advertiser')
             $advertiser_index = $index;
       }

       if ($advertiser_index == '') {
           return redirect('/upload-dcm-data')->with('Error', '"Advertiser" is a required field, please select "Advertiser" from any dropdown');
       }
   
       $duplicate_values = array();
       foreach(array_count_values($number_of_values) as $val => $c)
           if($c > 1) $duplicate_values[] = $val;

       if ($duplicate_values) {
       
           Session::flash('duplicate_values', array_unique($duplicate_values));
           return redirect('/upload-dcm-data')->with('Error', 'You have selected duplicate fields. Below are the duplicated fields.');
       } 

       $selected_values = array_unique($request->fields);
     
       $data = CsvFile::find($request->csv_data_file_id);
       $csv_data = json_decode($data->csv_data, true);
  
       switch ($data->data_import_type) {
           case 'merge':

               foreach ($csv_data as $row) {
                   if ($count > 0) {
                       $existing_advertiser = DCM::where('advertiser', $row[$advertiser_index])->first();
                       if (empty($existing_advertiser)) {

                           $DCM = new DCM();
                           foreach ($selected_values as $index => $field) {
                               if ($field == 'not_seclected') continue;
                               if (isset($row[$index])) {
                                   $DCM->$field = strip_tags($row[$index]);
                               }
                           }

                           $DCM->save();
                       }

                   }

                   $count++;
               }
               
               break;
           
           case 'overwrite':

               foreach ($csv_data as $row) {
                   if ($count > 0) {
                       
                       $existing_advertiser = DCM::where(['advertiser' => $row[$advertiser_index]])->first();

                       if (!empty($existing_advertiser)) {

                           $DCM = DCM::find($existing_advertiser->id);
   
                           foreach ($DCM->getFillable() as $index => $value){
                               if (!in_array($value, $selected_values)){
                                   $empty_fields[] =  $value; 
                               }
                           }

                           foreach ($selected_values as $index => $field) {
                               if ($field == 'not_seclected') continue;
                               $DCM->$field = strip_tags($row[$index]);
                           }

                           if (!empty($empty_fields)) {
                               foreach ($empty_fields as $index => $field) {
                                   $DCM->$field = null;
                               }
                           }

                           $DCM->save();

                       } else {

                           $DCM = new DCM();
                           foreach ($selected_values as $index => $field) {
                               if ($field == 'not_seclected') continue;
                               $DCM->$field = strip_tags($row[$index]);
                           }

                           $DCM->save();
                       }

                   }

                   $count++;
               }
               break;

           case 'delete':

               foreach ($csv_data as $row) {
                   if ($count > 0) {

                       $existing_advertiser = DCM::where('advertiser', $row[$advertiser_index])->delete();

                       $DCM = new DCM();
                       foreach ($selected_values as $index => $field) {
                           if ($field == 'not_seclected') continue;
                           $DCM->$field = strip_tags($row[$index]);
                       }

                       $DCM->save();
                   }

                   $count++;
               }

               break;
       }

       return redirect('/dcms')->with('success', 'DCM Data imported successfully.');

   }
}
