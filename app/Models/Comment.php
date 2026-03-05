<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'body'
    ];
    public $timestamps = false;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function post(){
        return $this->belongsTo(Post::class);
    }
    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    public function allReplies() {
        return $this->hasMany(Comment::class, 'parent_id')
            ->with(['allReplies', 'user', 'myLike', 'parent.user'])
            ->withCount('likes');
    }
    public function myLike() {
        return $this->hasOne(CommentLike::class)->where('user_id', \Illuminate\Support\Facades\Auth::id() ?? 0);
    }
    public function getLikedByMeAttribute($value) {
        if ($value !== null) return (bool) $value;
        // Ensure you use array_key_exists so we don't accidentally load the relationship if it wasn't loaded 
        // Or safely check if the relation is loaded
        if ($this->relationLoaded('myLike')) {
            return $this->myLike !== null;
        }
        return false;
    }
    protected $appends = ['liked_by_me'];

    public function likes() {
        return $this->hasMany(CommentLike::class);
    }
    public function likesCount()
    {   
        return $this->likes()->count();
    }
}
