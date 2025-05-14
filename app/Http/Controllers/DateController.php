<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;

class DateController extends Controller
{	
    public function search($date) {
		return view('date.search', [
			'posts' => Post::with(['user', 'tags'])
						   ->withCount('comments')      // Procura entre as 00:00 e 23:59, porque se comparasse se é igual sem esta filtragem, cairia sempre no falto por ter horas diferente
						   ->whereBetween('created_at', [Carbon::createFromFormat('d-m-Y', $date)->startOfDay(), Carbon::createFromFormat('d-m-Y', $date)->endOfDay()])
						   ->latest('id')
						   ->get()
		]);
	}
}
