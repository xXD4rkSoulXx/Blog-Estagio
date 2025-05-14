<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
	
	protected $table = 'posts';
	protected $fillable = ['title', 'text', 'wallpaper', 'statistics', 'user_id'];
	
	protected function casts(): array
    {
        return [
            'statistics' => 'array' // Faz o json_encode e json_decode automáticamente
        ];
    }
	
	public function user() {
		return $this->belongsTo(User::class);
	}
	
	public function tags() {
		return $this->belongsToMany(Tag::class);
	}
	
	public function comments() {
		return $this->hasMany(Comment::class);
	}
}
