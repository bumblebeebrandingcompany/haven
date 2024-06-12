<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $appends = ['is_superadmin', 'is_agency', 'is_channel_partner', 'is_channel_partner_manager', 'is_presales', 'is_frontoffice'];

    public $table = 'applications';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'follow_up_date',

    ];
    protected $fillable = [
        'application_no',
        'application_date',
        'application_time',
        'notes',
        'stage_id',
        'who_assigned',
        'for_whom',
        'lead_id',
        'created_at',
        'updated_at'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
    public function application()
    {
        return $this->hasMany(Application::class, 'application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'who_assigned');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'for_whom');
    }
}
