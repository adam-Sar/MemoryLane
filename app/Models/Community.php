<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Community extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'user_id',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the user that created the community.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the posts belonging to the community.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    /**
     * Get the members of the community.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'community_members')
            ->withTimestamps();
    }
    
    /**
     * Check if a user is a member of the community.
     */
    public function hasMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }
    
    /**
     * Boot method to auto-generate slug from name.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($community) {
            if (empty($community->slug)) {
                $community->slug = Str::slug($community->name);
            }
        });
    }
    
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}