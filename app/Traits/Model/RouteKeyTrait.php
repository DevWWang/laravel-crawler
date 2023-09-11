<?php

namespace App\Traits\Model;

use App\Services\HashId\HashIdService;

trait RouteKeyTrait
{
    public function getRouteKey()
    {
        return (new HashIdService())->encode($this->getAttribute($this->getRouteKeyName()));
    }
}