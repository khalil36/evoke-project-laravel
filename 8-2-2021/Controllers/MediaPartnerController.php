<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ValidateImportFile;
use App\Http\Requests\ValidateMediaPartner;
use App\Models\MediaPartnerULD;
use App\Models\MediaPartner;
use App\Models\CsvFile;
use App\Imports\MediaPartnerULDImport;
use DB, Auth, User, Session, DateTime;

class MediaPartnerController extends Controller
{

    /**
     * Show the Media Partners screen.
     * @return \Illuminate\View\media-partners\index
     */
    public function index()
    {
        $tmp_media_partners = array();
        $media_partners = array();

        $get_media_partners = DB::table('media_partners')
                        ->select('media_partners.*', 'users.name')
                        ->orderBy('media_partners.id','DESC')
                        ->join('users', 'users.id', '=', 'media_partners.created_by_user_id')
                        ->where('media_partners.team_id', Auth::user()->current_team_id)
                        ->paginate(20);

        if (!empty($get_media_partners)) {

            foreach ($get_media_partners as $media_partner){
                $MediaPartner_Present = MediaPartnerULD::where( 'media_partner_id', $media_partner->id)->orderBy('id', 'DESC')->count();
                $MediaPartner_Date = MediaPartnerULD::select('date')->where( 'media_partner_id', $media_partner->id)->orderBy('id', 'DESC')->first();
        
                $last_record_date = 'N/A';
                if(isset($MediaPartner_Date)) {
                    $last_record_date = date('Y-m-d', strtotime($MediaPartner_Date->date));
                }

                $tmp_media_partners['media_partner_id'] = $media_partner->id;
                $tmp_media_partners['media_partner_date'] = $last_record_date;
                $tmp_media_partners['media_partner_present'] = ($MediaPartner_Present > 0 ? true : false);
                $tmp_media_partners['media_partner_name'] = $media_partner->media_partner_name;
                $tmp_media_partners['added_by_user_name'] = $media_partner->name;
                $tmp_media_partners['media_partner_created_at'] = $media_partner->created_at;

                $media_partners[] = $tmp_media_partners;
                unset($tmp_media_partners);
            }

        }
        
        return view('media-partners.index', compact('media_partners','get_media_partners'));
    }

    /**
     * Show the Media Partner screen.
     * @return \Illuminate\View\media-partners\create
     */
    public function create()
    {
        return view('media-partners.create');
    }

    /**
     * Save the Media Partner name.
     * @return \Illuminate\View\media-partners
     */
    public function save(ValidateMediaPartner $request)
    {
        MediaPartner::create([
            'media_partner_name' => $request->media_partner_name,
            'team_id' => Auth::User()->current_team_id,
            'created_by_user_id' => Auth::User()->id,
        ]);

        return redirect('/media-partners')->with('created', 'Media partner has been created successfully.');

    }
     /**
     * Save the Media Partner name.
     * @return \Illuminate\View\media-partners\create
     */
    public function uploadMediaPartnerULD()
    {
        $media_partners = MediaPartner::where('team_id', Auth::user()->current_team_id)->orderBy('id', 'ASC')->get();
        return view('media-partners.upload_media_partner_uld', compact('media_partners'));
    }

    /**
     * Map the Media Partner fields.
     * @return \Illuminate\View\media-partners\map_fields
    */
    public function mapMediaPartnerULD(ValidateImportFile $request)
    {
    
        if ($request->media_partner_id == 0) {
            return redirect('/upload-media-partner-ulds')->with('Error', 'Please select a media partner from media partner dropdown.');
        }



        $path = $request->file('csv_file')->getRealPath();
        $file_name = $request->file('csv_file')->store('uploads', 'public');
        $count = 0;
        $file = fopen($path, 'r');

       // $extension = $request->file('csv_file')->extension();
        //Excel::filter('chunk')->load($path)->chunk(1, function($results)
        //$data = Excel::toArray(new MediaPartnerULDImport, $request->file('csv_file')->chunk(1));

        // {
        //         foreach($results as $row)
        //         {
        //             $data[] = $row;
        //         }
        // });


        while (($row = fgetcsv($file)) !== FALSE) {
            if ($count > 2) break;
               $data[] = $row;
               $count++;

        }
        fclose($file);

        //echo "<pre>"; print_r($data); exit();

       //  if ($extension == 'csv') {
       //      $data = array_map('str_getcsv', file($path));
       //  } else{
           
       //      $csv_data = Excel::toArray(new MediaPartnerULDImport, $request->file('csv_file'));
            
       //      if(!empty($csv_data)){
                
       //         foreach ($csv_data as $key => $value) {
       //          if ($count > 4) break; 

       //             if(!empty($value)){
       //                 foreach ($value as $v) { 
       //                     $data[] = $v;
       //                 }
       //             }
       //          $count++;
       //         }
       //     }
       // }

       

       //  DB::select(DB::raw('TRUNCATE TABLE  csv_file'));

        $csv_data_file = CsvFile::create([
           // 'csv_filename' => $request->file('csv_file')->getClientOriginalName() ."__". $file_name,
            'csv_filename' => $file_name,
            'csv_header' => $request->has('header'),
           // 'csv_data' => json_encode($data),
            'csv_data' => '',
            'data_import_type' => $request->import_option,
            'media_partner_id' => $request->media_partner_id,
        ]);

        //$csv_data = array_slice($data, 0, 3);
        $csv_data = $data;

        $media_partner_uld_fields = MediaPartnerULD::getColumns();
        return view('media-partners.map_fields', compact('csv_data', 'csv_data_file', 'media_partner_uld_fields'));

    }

    /**
     * Show the MediaPartnerULD import screen.
     * @return \Illuminate\View\media-partners\import_MediaPartnerULD
     */
    public function processUpload(Request $request)
    {
      
        $selected_values = $number_of_values =  array(); 
        $npi_index = ''; $count = 0;

        foreach ($request->fields as $index =>$value) {
            if ($value == 'not_selected') continue;
            $number_of_values[] = $value;
        }
    
        $duplicate_values = array();
        foreach(array_count_values($number_of_values) as $val => $c)
            if($c > 1) $duplicate_values[] = $val;

        if ($duplicate_values) {
        
            Session::flash('duplicate_values', array_unique($duplicate_values));
            return redirect('/upload-media-partner-ulds')->with('Error', 'You have selected duplicate fields. Below are the duplicated fields.');
        } 

        $selected_values = array_unique($request->fields);
      
        $data = CsvFile::find($request->csv_data_file_id);
        $file = fopen(storage_path('app/public/'.$data->csv_filename), 'r');

       // $data = file(storage_path('app/public/'.$data->));
        //$csv_data = array_map('str_getcsv', file(storage_path('app/public/'.$data->csv_filename)));

 
       // $csv_data = json_decode($data->csv_data, true);


        switch ($data->data_import_type) {
            
            case 'append':

                //foreach ($csv_data as $row) {
                while (($row = fgetcsv($file)) !== FALSE){
                    if ($count > 0) {
                
                        $MediaPartnerULD = new MediaPartnerULD();
                        foreach ($selected_values as $index => $field) {
                            if ($field == 'not_selected') continue;

                            if ($field == 'date' ) {
                                if (DateTime::createFromFormat('Y-m-d H:i:s', strip_tags($row[$index])) == false) {
                                    continue;
                                }
                                $MediaPartnerULD->$field = date('Y-m-d H:i:s', strtotime(strip_tags($row[$index])));
                            } else {
                                $MediaPartnerULD->$field = strip_tags($row[$index]);
                            }
                        }

                        $MediaPartnerULD->media_partner_id = $data->media_partner_id;
                        $MediaPartnerULD->save();
                    
                    }

                    $count++;
                }
                break;

            case 'delete':

                MediaPartnerULD::where('media_partner_id', $data->media_partner_id)->delete();
                //foreach ($csv_data as $row) {
                while (($row = fgetcsv($file)) !== FALSE){
                    if ($count > 0) {

                        $MediaPartnerULD = new MediaPartnerULD();
                        foreach ($selected_values as $index => $field) {
                            if ($field == 'not_selected') continue;
                            
                            if ($field == 'date' ) {
                                if (DateTime::createFromFormat('Y-m-d H:i:s', strip_tags($row[$index])) == false) {
                                    continue;
                                }
                                continue;
                                $MediaPartnerULD->$field = date('Y-m-d H:i:s', strtotime(strip_tags($row[$index])));
                            } else {
                                $MediaPartnerULD->$field = strip_tags($row[$index]);
                            }
                        }

                        $MediaPartnerULD->media_partner_id = $data->media_partner_id;
                        $MediaPartnerULD->save();
                    }

                    $count++;
                }

                break;
        }
        fclose($file);
        return redirect('/media-partners')->with('success', 'Media Partner ULDs Data imported successfully.');

    }
}
