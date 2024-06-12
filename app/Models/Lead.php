<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use Auditable, HasFactory;

    public $table = 'leads';

    protected $appends = ['lead_info'];

    public static $searchable = [
        'email',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const DEFAULT_WEBHOOK_FIELDS = [
        'name', 'email',
        'phone', 'predefined_comments',
        'predefined_cp_comments', 'predefined_created_by',
        'predefined_created_at', 'predefined_source_name',
        'predefined_campaign_name', 'predefined_agency_name',
        'predefined_additional_email', 'predefined_secondary_phone',
        'predefined_source_field1', 'predefined_source_field2',
        'predefined_source_field3', 'predefined_source_field4',
        'predefined_lead_ref_no',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'lead_details' => 'array',
        'webhook_response' => 'array',
        'lead_event_webhook_response' => 'array',

    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function subsource()
    {
        return $this->hasMany(SubSource::class, 'sub_source_id');
    }
    

    public function events()
    {
        return $this->hasMany(LeadEvents::class, 'lead_id');
    }
    public static function selldoform($input)
    {
  
        return new static($input);
    }
    
    public function flattenData($datas)
    {
        $singleDimArr = [];
        foreach ($datas as $key => $data) {
            if (!empty($data) && !is_array($data)) {
                $singleDimArr[$key] = $data;
            }

            if (!empty($data) && is_array($data)) {
                $singleDimArr = array_merge($singleDimArr, $this->flattenData($data));
            }
        }
        return $singleDimArr;
    }

    /**
     * Get lead details by converting 2D[] => 1D[]
     */
    public function getLeadInfoAttribute()
    {
        $lead_info = [];
        $lead_details = $this->lead_details;

        if (empty($lead_details)) {
            return $lead_info;
        }

        foreach ($lead_details as $key => $lead_detail) {
            if (!empty($lead_detail) && !is_array($lead_detail)) {
                $lead_info[$key] = $lead_detail;
            }

            if (!empty($lead_detail) && is_array($lead_detail)) {
                $lead_info = array_merge($lead_info, $this->flattenData($lead_detail));
            }
        }

        return $lead_info;
    }
    public function getEventTypeAttribute()
    {
        $response = $this->lead_event_webhook_response;
        return $response['event'] ?? null;
    }
    public static function getStages($projectId)
    {
        $lead_stages = Lead::where('project_id', $projectId)
            ->whereNotNull('sell_do_fields')
            ->get(['sell_do_fields', 'system_fields'])
            ->map(function ($lead) {
                $sell_do_stage = json_decode($lead->sell_do_fields, true)['Sell Do Stage'] ?? null;
                return [
                    'Sell Do Stage' => $sell_do_stage,
                ];
            })
            ->filter(function ($lead) {
                return $lead['Sell Do Stage'] !== null;
            })
            ->pluck('Sell Do Stage')
            ->unique()
            ->toArray();
    
        $unique_stages = array_unique($lead_stages);
        $unique_stages[] = 'no_stage';
    
        $card_classes = ['card-primary', 'card-danger', 'card-success', 'card-info', 'card-warning', 'card-secondary', 'card-dark'];
    
        $stages_with_details = [];
        foreach ($unique_stages as $stage) {
            $stages_with_details[$stage] = [
                'class' => $card_classes[array_rand($card_classes)],
                'title' => ucfirst(str_replace('_', ' ', $stage)),
            ];
        }
    
        return $stages_with_details;
    }
    
}
