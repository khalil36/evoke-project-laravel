<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaPartner extends Model
{
    use HasFactory;

    protected $table = 'media_partners';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'team_id',
        'media_partner_name',
        'created_by_user_id',
    ];
}
