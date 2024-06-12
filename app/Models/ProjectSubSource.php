<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSubSource extends Model
{
    use Auditable, HasFactory;

    public $table = 'project_sub_sources';

    public static $searchable = [
        'name',
    ];

    protected $fillable = [
        'source_id',
        'name',
        'srd',
    ];
    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $guarded = ['id'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function source()
    {
        return $this->belongsTo(ProjectSource::class);
    }

}
