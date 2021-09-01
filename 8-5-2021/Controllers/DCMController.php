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
       $file_name = $request->file('csv_file')->store('uploads', 'public');
       $count = 0; $csv_data= array();
      

       if ($extension == 'csv') {
            $file = fopen($path, 'r');

            while (($row = fgetcsv($file)) !== FALSE) {
              
               if ($count > 2) break;
                  $csv_data[] = $row;
                  $count++;

            }
            fclose($file);

       } else {
           
           $file_data = Excel::toArray(new DCMDataImport, $request->file('csv_file'));

           if(!empty($file_data)){
           
              foreach ($file_data as $key => $value) {

                  if(!empty($value)){

                      foreach ($value as $v) {  
                        if ($count > 2) break;      
                          $csv_data[] = $v;
                        $count++;
                      }
                  }
                
              }
          }
       }

       $csv_data_file = CsvFile::create([
           'csv_filename' => $file_name,
           'csv_data' => $extension,
           'data_import_type' => $request->import_option,
       ]);


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

       $file_has_column_header = $request->data_has_column_headers;

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
     
       $csvfile_data = CsvFile::find($request->csv_data_file_id);
       $extension = $csvfile_data->csv_data;

       switch ($csvfile_data->data_import_type) {

         case 'append':

                if ($extension == 'csv') {

                    $file = fopen(storage_path('app/public/'.$csvfile_data->csv_filename), 'r');
                    while (($row = fgetcsv($file)) !== FALSE){
                        if ( ($file_has_column_header == 'yes' && $count > 0) || (empty($file_has_column_header) && $count >= 0) )
                        {

                            $DCM = new DCM();
                            foreach ($selected_values as $index => $field) {
                               if ($field == 'not_selected') continue;

                               if ($field == 'date') {
                                   $DCM->$field = date('Y-m-d', strtotime(strip_tags($row[$index])));
                               } elseif ($field == 'impression_reach' or $field == 'click_reach' or $field == 'total_reach' or $field == 'average_impression_frequency') {
                                   $DCM->$field = strip_tags((float)$row[$index]);
                               } else {
                                   $DCM->$field = strip_tags((string)$row[$index]);
                               }

                            }

                            $DCM->team_id = Auth::user()->current_team_id;
                            $DCM->save();
                        
                        }

                        $count++;
                    }
                    fclose($file);

                } else {

                    $file_data = Excel::toArray(new DCMDataImport, storage_path('app/public/'.$csvfile_data->csv_filename));

                    if(!empty($file_data)){

                        foreach ($file_data as $key => $data) {

                            foreach ($data as $row) {   

                                if ( ($file_has_column_header == 'yes' && $count > 0) || (empty($file_has_column_header) && $count >= 0) )
                                {

                                    $DCM = new DCM();
                                    foreach ($selected_values as $index => $field) {
                                        if ($field == 'not_selected') continue;

                                        if ($field == 'date') {

                                           $DCM->$field = date('Y-m-d', strtotime(strip_tags($row[$index])));

                                        } elseif ($field == 'impression_reach' or $field == 'click_reach' or $field == 'total_reach' or $field == 'average_impression_frequency') {

                                            $DCM->$field = strip_tags((float)$row[$index]);

                                        } else {

                                           $DCM->$field = strip_tags((string)$row[$index]);
                                        }

                                    }

                                    $DCM->team_id = Auth::user()->current_team_id;
                                    $DCM->save();
                                }

                                $count++;   
                           
                            }
                          
                        }
                    }
                }

                break;

           case 'delete':

                DCM::where('team_id', Auth::user()->current_team_id)->delete();

                if ($extension == 'csv') {
                    $file = fopen(storage_path('app/public/'.$csvfile_data->csv_filename), 'r');
                    while (($row = fgetcsv($file)) !== FALSE){
                       if ( ($file_has_column_header == 'yes' && $count > 0) || (empty($file_has_column_header) && $count >= 0) )
                        {

                           $DCM = new DCM();
                           foreach ($selected_values as $index => $field) {
                               if ($field == 'not_selected') continue;

                               if ($field == 'date') {
                                   $DCM->$field = date('Y-m-d', strtotime(strip_tags($row[$index])));
                               } elseif ($field == 'impression_reach' or $field == 'click_reach' or $field == 'total_reach' or $field == 'average_impression_frequency') {
                                   $DCM->$field = strip_tags((float)$row[$index]);
                               } else {
                                   $DCM->$field = strip_tags((string)$row[$index]);
                               }
                           }

                           $DCM->team_id = Auth::user()->current_team_id;
                           $DCM->save();
                       }

                       $count++;
                   }
                   fclose($file);

                } else {

                    $file_data = Excel::toArray(new DCMDataImport, storage_path('app/public/'.$csvfile_data->csv_filename));

                    if(!empty($file_data)){

                        foreach ($file_data as $key => $data) {

                            foreach ($data as $row) {   

                                if ( ($file_has_column_header == 'yes' && $count > 0) || (empty($file_has_column_header) && $count >= 0) )
                                {
                                    $DCM = new DCM();
                                    foreach ($selected_values as $index => $field) {
                                       if ($field == 'not_selected') continue;

                                       if ($field == 'date') {
                                           $DCM->$field = date('Y-m-d', strtotime(strip_tags($row[$index])));
                                       } elseif ($field == 'impression_reach' or $field == 'click_reach' or $field == 'total_reach' or $field == 'average_impression_frequency') {
                                           $DCM->$field = strip_tags((float)$row[$index]);
                                       }else {
                                           $DCM->$field = strip_tags((string)$row[$index]);
                                       }
                                    }

                                    $DCM->team_id = Auth::user()->current_team_id;
                                    $DCM->save();
                                }
                                $count++;   
                           
                            }
                          
                        }
                    }

                }
                

               break;
       }

       return redirect('/dcms')->with('success', 'DCM Data imported successfully.');

   }
}
