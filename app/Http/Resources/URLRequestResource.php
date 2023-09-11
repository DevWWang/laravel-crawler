<?php

namespace App\Http\Resources;

use App\Traits\Resource\ResolveRelationshipTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class URLRequestResource extends JsonResource
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
            "hid" => $this->getRouteKey(),
            "url" => $this->url,
            "host" => $this->host,
            "path" => $this->path,
            "status_code" => $this->status_code,
            "error_message" => $this->error_message,
            "created_at" => $this->created_at->timestamp,
            "updated_at" => $this->updated_at->timestamp,
            $this->mergeWhen(
                $this->resource->relationLoaded("website_metadata"),
                function() {
                    $metadata = new WebsiteMetadataResource($this->website_metadata);
                    if ($this->resolveRelationship) {
                        $metadata = $metadata->resolve();
                    }
                    return [
                        "base_url" => Storage::disk($this->getStorageDisk())->url($this->host),
                        "website_metadata" => $metadata
                    ];
                }
            )
        ];
    }
}
