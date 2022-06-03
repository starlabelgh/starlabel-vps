<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Shipu\Watchable\Traits\HasAuditColumn;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


class Visitor extends Model implements  HasMedia
{
    use Notifiable;
    use HasMediaTrait;
    use HasAuditColumn;


    protected $table = 'visitors';
    protected $guarded = ['id'];
    protected $auditColumn = true;

    protected $fakeColumns = [];

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function invitation()
    {
        return $this->hasOne(PreRegister::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function preregister()
    {
        return $this->hasOne(PreRegister::class);
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getMyStatusAttribute()
    {
        return trans('statuses.' . $this->status);
    }
    public function getMyGenderAttribute()
    {
        return trans('genders.' . $this->gender);
    }
    public function getImagesAttribute()
    {
        if (!empty($this->getFirstMediaUrl('visitor'))) {
            return asset($this->getFirstMediaUrl('visitor'));
        }
        return asset('assets/img/default/user.png');
    }

    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }
}
