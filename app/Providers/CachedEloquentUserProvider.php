<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class CachedEloquentUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return Cache::remember('user_'.$identifier, 3600, function () use ($identifier) {
            return parent::retrieveById($identifier);
        });
    }
}
