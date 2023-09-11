<?php

namespace App\Traits\Resource;

trait ResolveRelationshipTrait
{
    /**
     * @var bool
     */
    protected $resolveRelationship = false;

    public function resolveRelationship($resolveRelationship)
    {
        $this->resolveRelationship = $resolveRelationship;
        return $this;
    }
}