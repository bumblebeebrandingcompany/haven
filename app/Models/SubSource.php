<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SubSource extends Model
{
    use Auditable, HasFactory;

    public $table = 'sub_sources';

    public static $searchable = [
        'name',
    ];
    protected $fillable = [
        'source_id',
        'name',
        'srd',
        'project_id',
        'webhook_secret',
        'otp_verified_or_not'

    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'custom_fields' => 'array',
        'essential_fields'=>'array',
        'sell_do_fields'=>'array',
        'sales_fields'  => 'array',
        'system_fields' => 'array',
        'inbox_fields' => 'array',
    ];
    protected $guarded = ['id'];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
    public function subsources()
    {
        return $this->hasMany(Lead::class, 'subsource_id', 'id');
    }
}
