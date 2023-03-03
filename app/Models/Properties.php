<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    protected $table = 'properties';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'price',
        'bathrooms',
        'bedrooms',
        'user_id',
        'published',
    ];

    protected $casts = [
        'price' => 'float'
    ];

    public function images()
    {
        return $this->hasMany('App\Models\PropertiesImage');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($property) {
            foreach ($property->images as $image) {
                $image->delete();
            }
        });
    }
}
