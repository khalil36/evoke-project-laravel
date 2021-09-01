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
        $dcms = DCM::where('team_id', Auth::user()->current_team_id)->orderBy('id', 'DESC')->paginate(20);
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
       $count = 0;

       foreach ($request->fields as $index =>$value) {
           if ($value == 'not_selected') continue;
           $number_of_values[] = $value;
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

         case 'append':

                foreach ($csv_data as $row) {
                    if ($count > 0) {
                
                        $DCM = new DCM();
                        foreach ($selected_values as $index => $field) {
                           if ($field == 'not_selected') continue;

                           if ($field == 'date') {
                               $DCM->$field = date('Y-m-d', strtotime(strip_tags($row[$index])));
                           } else {
                               $DCM->$field = strip_tags($row[$index]);
                           }

                        }

                        $DCM->team_id = Auth::user()->current_team_id;
                        $DCM->save();
                    
                    }

                    $count++;
                }
                break;

           case 'delete':

                DCM::where('team_id', Auth::user()->current_team_id)->delete();
                
                foreach ($csv_data as $row) {
                   if ($count > 0) {


                       $DCM = new DCM();
                       foreach ($selected_values as $index => $field) {
                           if ($field == 'not_selected') continue;

                           if ($field == 'date') {
                               $DCM->$field = date('Y-m-d', strtotime(strip_tags($row[$index])));
                           } else {
                               $DCM->$field = strip_tags($row[$index]);
                           }
                       }

                       $DCM->team_id = Auth::user()->current_team_id;
                       $DCM->save();
                   }

                   $count++;
               }

               break;
       }

       return redirect('/dcms')->with('success', 'DCM Data imported successfully.');

   }
}
