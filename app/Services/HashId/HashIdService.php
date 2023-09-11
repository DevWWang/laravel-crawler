<?php

namespace App\Services\HashId;

use Hashids\Hashids;

class HashIdService
{
    public $hashIds;

    /**
     * Instantiate a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->hashIds = new Hashids(config('services.hashid.salt'), 8);
    }

    public function encode($id)
    {
        return $this->hashIds->encode($id);
    }

    public function decode($hashId)
    {
        if(is_int($hashId)) return $hashId;
        return $this->hashIds->decode($hashId)[0];
    }
}