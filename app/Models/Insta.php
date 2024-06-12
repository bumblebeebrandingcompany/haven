<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insta extends Model
{
    use Auditable, HasFactory;

    public $table = 'insta';

    public static $searchable = [
        'bot_name',
    ];
    protected $fillable = [
        'id',
        'bot_name',
        'bot_api',
        'chat_id',
        'user_id',
        'team_id',
        'created_at',
        'updated_at',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
