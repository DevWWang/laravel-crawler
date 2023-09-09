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
        'publish_date' => 'datetime',
    ];

    /**
     * Get the url request that owns the website metadata.
     */
    public function urlRequest()
    {
        return $this->belongsTo(URLRequest::class)->withTimestamps();
    }
}
