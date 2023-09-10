<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class URLRequest extends Model
{
    use HasFactory;

    const DISK_NAME = "url-host";
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "url_requests";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'host',
        'path',
        'status_code',
        'error_message'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        "updated_at" => "datetime"
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
            $parsedUrl = parse_url($model->url);

            $model->host = $parsedUrl["host"];
            $model->path = $parsedUrl["path"] ?? null;
        });
    }

    /**
     * Get the metadata associated with the url.
     */
    public function website_metadata()
    {
        return $this->hasOne(WebsiteMetadata::class, "request_id");
    }
}
