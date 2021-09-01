<?php

namespace App\Http\Controllers;

use App\Google\Services\Analytics\DfaReader;
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
    public function create(DfaReader $reader)
    {
        $sites = $reader->getSites();
        return view('media-partners.create',['sites'=>$sites]);
    }

    /**
     * Save the Media Partner name.
     * @return \Illuminate\View\media-partners
     */
    public function save(ValidateMediaPartner $request)
    {   

        $dfa_site = str_replace('"', "", $request->dfa_site_name);    
        if (empty($dfa_site)) {
            return redirect('/media-partners/create')->with('Error', 'Please select campaign manager site from dropdown first');
        }
        //dd($request);
        MediaPartner::create([
            'media_partner_name' => $request->media_partner_name,
            'dfa_site' => $dfa_site,
            'ga_site_source' => '',
            'team_id' => Auth::User()->current_team_id,
            'created_by_user_id' => Auth::User()->id,
        ]);

        return redirect('/media-partners')->with('created', 'Media partner has been created successfully.');

    }

     /**
     * Edit Media Partner screen.
     * @return \Illuminate\View\media-partners\edit
     */
    public function edit(DfaReader $reader, $id)
    {
        $sites = $reader->getSites();
        $media_partner = MediaPartner::find($id);
        return view('media-partners.edit',  compact('media_partner', 'sites'));
    }

    /**
     * Save the Media Partner name.
     * @return \Illuminate\View\media-partners
     */
    public function update(ValidateMediaPartner $request, $id)
    {   

        $dfa_site = str_replace('"', "", $request->dfa_site_name);    
        if (empty($dfa_site)) {
            return redirect('/media-partners/edit/'.$id)->with('Error', 'Please select campaign manager site from dropdown first');
        }

        $media_partner = MediaPartner::find($id);
        $media_partner->media_partner_name = $request->media_partner_name;
        $media_partner->dfa_site = $dfa_site;
        $media_partner->save();

        return redirect('/media-partners')->with('updated', 'Media partner has been updated successfully.');

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

             $file_data = Excel::toArray(new MediaPartnerULDImport, $request->file('csv_file'));

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

        //Excel::filter('chunk')->load($path)->chunk(1, function($results)
        //$data = Excel::toArray(new MediaPartnerULDImport, $request->file('csv_file')->chunk(1));

        // {
        //         foreach($results as $row)
        //         {
        //             $data[] = $row;
        //         }
        // });


        
        $csv_data_file = CsvFile::create([
            'csv_filename' => $file_name,
            'csv_data' => $extension,
            'data_import_type' => $request->import_option,
            'media_partner_id' => $request->media_partner_id,
        ]);

        $media_partner_uld_fields = MediaPartnerULD::getColumns();
        return view('media-partners.map_fields', compact('csv_data', 'csv_data_file', 'media_partner_uld_fields'));

    }

    /**
     * Show the MediaPartnerULD import screen.
     * @return \Illuminate\View\media-partners\import_MediaPartnerULD
     */
    public function processUpload(Request $request)
    {

       // echo "hascolumn: ". $request->data_has_column_headers; exit();

        $selected_values = array();
        $number_of_values = array();
        $not_valid_dates = array();
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
            return redirect('/upload-media-partner-ulds')->with('Error', 'You have selected duplicate fields. Below are the duplicated fields.');
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
                    
                            $MediaPartnerULD = new MediaPartnerULD();
                            foreach ($selected_values as $index => $field) {
                                if ($field == 'not_selected') continue;

                                if ($field == 'date' ) {
                                    if(strtotime(strip_tags($row[$index]))){
                                        $MediaPartnerULD->$field = date('Y-m-d H:i:s', strtotime(strip_tags($row[$index])));
                                    } else {
                                       // $not_valid_dates[] = strip_tags($row[$index]);
                                         $not_valid_dates[] = $row;
                                         Session::flash('not_valid_dates', $row);
                                         return redirect('/upload-media-partner-ulds');
                                    }
                                } else {
                                    $MediaPartnerULD->$field = strip_tags((string)$row[$index]);
                                }
                            }

                            // if (in_array($row, $not_valid_dates)) {
                            //     Session::flash('not_valid_dates', array_unique($not_valid_dates));
                            // }

                            $MediaPartnerULD->media_partner_id = $csvfile_data->media_partner_id;
                            $MediaPartnerULD->save();
                        
                        }

                        $count++;
                    }
                    fclose($file);
                } else {

                    $file_data = Excel::toArray(new MediaPartnerULDImport, storage_path('app/public/'.$csvfile_data->csv_filename));

                    if(!empty($file_data)){

                        foreach ($file_data as $key => $data) {
                            foreach ($data as $row) {
                                if ( ($file_has_column_header == 'yes' && $count > 0) || (empty($file_has_column_header) && $count >= 0) ) {
                                    $MediaPartnerULD = new MediaPartnerULD();
                                    foreach ($selected_values as $index => $field) {
                                        if ($field == 'not_selected') continue;

                                        if ($field == 'date' ) {
                                            if(strtotime(strip_tags($row[$index]))){
                                                $MediaPartnerULD->$field = date('Y-m-d H:i:s', strtotime(strip_tags($row[$index])));
                                            } else {
                                                Session::flash('not_valid_dates', $row);
                                                return redirect('/upload-media-partner-ulds');
                                                //$not_valid_dates[] = strip_tags($row[$index]);
                                            }
                                        } else {
                                            $MediaPartnerULD->$field = strip_tags((string)$row[$index]);
                                        }
                                    }

                                    if (in_array(strip_tags($row[$index]), $not_valid_dates)) {
                                        continue;
                                    }

                                    $MediaPartnerULD->media_partner_id = $csvfile_data->media_partner_id;
                                    $MediaPartnerULD->save();
                                
                                }
                                $count++;
                            }
                        }
                    }

                }

                break;

            case 'delete':

                MediaPartnerULD::where('media_partner_id', $csvfile_data->media_partner_id)->delete();
                if ($extension == 'csv') {
                    $file = fopen(storage_path('app/public/'.$csvfile_data->csv_filename), 'r');
                    while (($row = fgetcsv($file)) !== FALSE){
                        if ( ($file_has_column_header == 'yes' && $count > 0) || (empty($file_has_column_header) && $count >= 0) ) {

                            $MediaPartnerULD = new MediaPartnerULD();
                            foreach ($selected_values as $index => $field) {
                                if ($field == 'not_selected') continue;
                                
                                if ($field == 'date' ) {
                                    if(strtotime(strip_tags($row[$index]))){
                                        $MediaPartnerULD->$field = date('Y-m-d H:i:s', strtotime(strip_tags($row[$index])));
                                    } else {
                                        Session::flash('not_valid_dates', $row);
                                        return redirect('/upload-media-partner-ulds');
                                        //$not_valid_dates[] = strip_tags($row[$index]);
                                    }
                                } else {
                                    $MediaPartnerULD->$field = strip_tags((string)$row[$index]);
                                }
                            }

                            if (in_array(strip_tags($row[$index]), $not_valid_dates)) {
                                continue;
                            }

                            $MediaPartnerULD->media_partner_id = $csvfile_data->media_partner_id;
                            $MediaPartnerULD->save();
                        }

                        $count++;
                    }
                    fclose($file);
                } else {

                    $file_data = Excel::toArray(new MediaPartnerULDImport, storage_path('app/public/'.$csvfile_data->csv_filename));

                    if(!empty($file_data)){

                        foreach ($file_data as $key => $data) {
                            foreach ($data as $row) {
                                if ( ($file_has_column_header == 'yes' && $count > 0) || (empty($file_has_column_header) && $count >= 0) ) {
                                    $MediaPartnerULD = new MediaPartnerULD();
                                    foreach ($selected_values as $index => $field) {
                                        if ($field == 'not_selected') continue;

                                        if ($field == 'date' ) {
                                            if(strtotime(strip_tags($row[$index]))){
                                                $MediaPartnerULD->$field = date('Y-m-d H:i:s', strtotime(strip_tags($row[$index])));
                                            } else {
                                                Session::flash('not_valid_dates', $row);
                                                return redirect('/upload-media-partner-ulds');
                                                //$not_valid_dates[] = strip_tags($row[$index]);
                                            }
                                        } else {
                                            $MediaPartnerULD->$field = strip_tags((string)$row[$index]);
                                        }
                                    }

                                    if (in_array(strip_tags($row[$index]), $not_valid_dates)) {
                                        continue;
                                    }

                                    $MediaPartnerULD->media_partner_id = $csvfile_data->media_partner_id;
                                    $MediaPartnerULD->save();
                                
                                }
                                $count++;
                            }
                        }
                    }

                }

                break;
        }
        
        // if ($not_valid_dates) {
        //     Session::flash('not_valid_dates', array_unique($not_valid_dates));
        // } 
        return redirect('/media-partners')->with('success', 'Media Partner ULDs Data imported successfully.');

    }
}
