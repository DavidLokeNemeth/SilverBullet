<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->{$model->getKeyName()}) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });
    }

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];

    protected $fillable = [
//        'uuid',
        'property_type_id',
        'county',
        'country',
        'town',
        'description',
        'address',
        'image_full',
        'image_thumbnail',
        'num_bedrooms',
        'num_bathrooms',
        'price',
        'type',
        'updated_at',
        'created_at'
    ];

    public function propertyType()
    {
        return $this->belongsTo('App\PropertyType');
    }
}
