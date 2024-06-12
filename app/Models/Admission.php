<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $appends = ['is_superadmin', 'is_agency', 'is_channel_partner', 'is_channel_partner_manager', 'is_presales', 'is_frontoffice'];

    public $table = 'admissions';

    protected $dates = [
        'created_at',
        'updated_at',
        'admission_date',
    ];


    protected $fillable = [
        'admission_date',
        'admission_time',
        'notes',
        'stage_id',
        'application_id',
        'created_at',
        'updated_at'
    ];
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
