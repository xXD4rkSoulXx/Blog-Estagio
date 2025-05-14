<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{	
	public function search(Tag $tag) {
		return view('tags.search', [
			'posts' => $tag->posts()
						   ->withCount('comments')
						   ->latest('id')
						   ->get()
		]);
	}
}
