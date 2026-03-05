<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityMember extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'community_id',
        'user_id',
    ];
    
    /**
     * Get the community that the member belongs to.
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }
    
    /**
     * Get the user that is a member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}