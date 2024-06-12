<?php
namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public $table = 'notes';

    protected $dates = [
        'created_at',
      
    ];
    protected $fillable = ['sell_do_lead_id','lead_id','notes'];
    public function timeline()
{
    return $this->hasMany(LeadTimeline::class);
}
}
