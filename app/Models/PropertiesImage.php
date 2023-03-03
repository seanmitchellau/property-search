<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class PropertiesImage extends Model
{
    protected $table = 'properties_images';

    public $timestamps = true;

    protected $fillable = [
        'properties_id',
        'filename',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function property()
    {
        return $this->belongsTo('App\Models\Properties');
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($image) {
            Storage::disk('public')->delete($image->filename);
        });
    }
}
