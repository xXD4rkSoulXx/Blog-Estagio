<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
	
	protected $table = 'comments';
	protected $fillable = ['text', 'statistics', 'post_id', 'user_id'];
	
	protected function casts(): array
    {
        return [
            'statistics' => 'array' // Faz o json_encode e json_decode automáticamente
        ];
    }
	
	public function post() {
		return $this->belongsTo(Post::class);
	}
	
	public function user() {
		return $this->belongsTo(User::class);
	}
}
