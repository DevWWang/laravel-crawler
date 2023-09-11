<?php

namespace App\Http\Resources;

use App\Traits\Resource\ResolveRelationshipTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class WebsiteMetadataResource extends JsonResource
{
    use ResolveRelationshipTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title" => $this->title,
            "description" => $this->description,
            "screenshot_filename" => $this->screenshot_filename,
            "body_filename" => $this->body_filename,
            "published_time" => $this->published_time->timestamp ?? null,
            "created_at" => $this->created_at->timestamp,
            "updated_at" => $this->updated_at->timestamp,
            $this->mergeWhen(
                $this->resource->relationLoaded("url_request"),
                function() {
                    $url = new URLRequestResource($this->url_request);
                    if ($this->resolveRelationship) {
                        $url = $url->resolve();
                    }
                    return [
                        "base_url" => Storage::disk($this->url_request->getStorageDisk())->url($this->url_request->host),
                        "url_request" => $url
                    ];
                }
            )
        ];
    }
}
