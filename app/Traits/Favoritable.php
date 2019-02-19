<?php

namespace App\Traits;

use App\Favorite;
use Illuminate\Database\Eloquent\Model;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if(! $this->favorites()->where($attributes)->exists()){
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited()
    {
        $attributes = ['user_id' => auth()->id()];

        return !! $this->favorites()->where($attributes)->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }
}
