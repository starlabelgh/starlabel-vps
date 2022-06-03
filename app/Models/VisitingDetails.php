<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Shipu\Watchable\Traits\HasAuditColumn;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


class VisitingDetails extends Model implements  HasMedia
{
    use HasMediaTrait;
    use HasAuditColumn;

    protected $table = 'visiting_details';
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


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function visitor()
    {
        return $this->belongsTo(Visitor::class,'visitor_id');
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    public function getMyStatusAttribute()
    {
        return trans('statuses.' . $this->status);
    }

    public function getImagesAttribute()
    {
        if (!empty($this->getFirstMediaUrl('visitor'))) {
            return asset($this->getFirstMediaUrl('visitor'));
        }
        return asset('assets/img/default/user.png');
    }
}
