<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Npis extends Model
{
    use HasFactory;
    
    protected $table = 'npis';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'team_id',
        'npi',
        'first_name',
        'last_name',
        'email',
        'decile',
        'created_by_user_id',
    ];

    public static function getColumns()
    {
       return [
            'npi' =>'NPI',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'decile' => 'Decile'
        ];
    }

}
