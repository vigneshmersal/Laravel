<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

class Candidate extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'candidates';

    protected $hidden = [
        'password',
    ];

    protected $appends = [
        'file',
        'image',
    ];

    const RADIO_RADIO = [
        'radio1' => 'Radio 1',
        'radio2' => 'Radio 2',
    ];

    const SELECT_SELECT = [
        'select1' => 'Select1',
        'select2' => 'Select 2',
    ];

    protected $dates = [
        'date',
        'date_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'text',
        'email',
        'textarea',
        'password',
        'radio',
        'select',
        'checkbox',
        'integer',
        'float',
        'money',
        'date',
        'date_time',
        'time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setDateTimeAttribute($value)
    {
        $this->attributes['date_time'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getFileAttribute()
    {
        return $this->getMedia('file')->last();
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }
}
