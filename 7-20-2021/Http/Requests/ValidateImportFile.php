<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class ValidateImportFile extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'csv_file' => ['required', 'mimes:csv,xlsx'],
            'import_option' => ['required']
        ];
    }
}
