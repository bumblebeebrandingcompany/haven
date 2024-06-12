<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Srd extends Model
{
    use HasFactory;
    protected $table = "srd";

    protected $fillable = [
        'id',
        'campaign_name',
        'source',
        'sub_source',
        'project_name',
        'medium_name',
        'medium_value',
        'srd',
        'sell_do_project_id',
        'project_id',
    ];

}
