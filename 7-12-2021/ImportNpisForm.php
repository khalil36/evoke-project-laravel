<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Models\User;
use Laravel\Jetstream\Contracts\ParseNpis;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Redirect, Response, DB;
use App\Models\CsvFile;
use App\Models\Npis;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;


class ImportNpisForm extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    use WithFileUploads;

    public $csv_file;
    public $csv_data;
    public $file_name;
    public $csv_data_file;
    public $extension;
    public $data_new = array();


    public function parseImport()
    {
        
        $this->resetErrorBag();
        $this->validate([
            'csv_file' => 'required|mimes:csv,xlsx',
        ]);

        //$validated_data = $this->validate();
        //$name = $this->csv_file . microtime().'.'.$this->csv_file->extension();
        $this->extension = $this->csv_file->extension();
        $this->file_name = $this->csv_file->store('uploads', 'public');
        if ($this->extension == 'csv') {
            
            //$this->file_name = $this->csv_file->store('uploads', 'public');
            $data = array_map('str_getcsv', file(storage_path('app/public/'.$this->file_name)));
            // $this->csv_data_file = CsvFile::create([
            //     'csv_filename' =>  $this->file_name,
            //     'csv_header' => 1,
            //     'csv_data' => json_encode($data)
            // ]);

        } else {

            $data = Excel::load(storage_path('app/public/'.$this->file_name), function($reader) {})->get();

            if(!empty($data) && $data->count()){

                foreach ($data->toArray() as $key => $value) {

                    $this->data_new[] = $value;

                    if(!empty($value)){

                        foreach ($value as $v) {        

                            $data[] = ['title' => $v['title'], 'description' => $v['description']];

                        }
                    }
                }

                // if(!empty($insert)){
                //     Item::insert($insert);
                //     return back()->with('success','Insert Record successfully.');
                // }
            }

        }

        $this->csv_data_file = CsvFile::create([
                'csv_filename' =>  $this->file_name,
                'csv_header' => 1,
                'csv_data' => json_encode($data)
            ]);

        $this->csv_data = array_slice($data, 0, 3);

    }

    public function render()
    {
        if ($this->csv_data) {
          return view('npis.import_fields', ['csv_data' => $this->csv_data, 'csv_data_file'=> $this->csv_data_file, 'extension'=> $this->extension, 'data_new' =>$this->data_new]);
        } else {
            return view('livewire.import-npis-form');
        }
    }
}
