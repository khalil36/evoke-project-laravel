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


    public function parseImport()
    {
        
        $this->resetErrorBag();
        $this->validate([
            'csv_file' => 'required|mimes:csv',
        ]);

        //$validated_data = $this->validate();
        //$name = $this->csv_file . microtime().'.'.$this->csv_file->extension();
  
        $this->file_name = $this->csv_file->store('uploads', 'public');
      
        $data = array_map('str_getcsv', file(storage_path('app/public/'.$this->file_name)));


        $this->csv_data_file = CsvFile::create([
            'csv_filename' =>  $this->file_name,
            'csv_header' => 1,
            'csv_data' => json_encode($data)
        ]);
        
        $this->csv_data = array_slice($data, 0, 1);

    }

    public function render()
    {
        if ($this->csv_data) {
          return view('npis.import_fields', ['csv_data' => $this->csv_data, 'csv_data_file'=> $this->csv_data_file]);
        } else {
            return view('livewire.import-npis-form');
        }
    }
}
