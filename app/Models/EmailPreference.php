<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailPreference extends Model
{
    protected $table = 'email_preferences';
    public $timestamps = false;
    public $primaryKey = 'user_id';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'reminder_7_days',
        'reminder_same_day',
        'approved_or_denied_message'
    ];
}
