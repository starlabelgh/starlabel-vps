<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $guarded = ['id'];
    protected $fillable = [
        'title','date','checkin_time','checkout_time','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
