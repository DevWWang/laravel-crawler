<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteMetadata extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "website_metadata";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'screenshot_filename',
        'body_filename',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_time' => 'datetime',
    ];

    /**
     * Bootstrap any application services.
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function($model) {
            $model->description = $model->description == "" ? null : $model->description;
            $model->published_time = $model->published_time == "" ? null : $model->published_time;
        });
    }

    /**
     * Get the url request that owns the website metadata.
     */
    public function urlRequest()
    {
        return $this->belongsTo(URLRequest::class)->withTimestamps();
    }
}
