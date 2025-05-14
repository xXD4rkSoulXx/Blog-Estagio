<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PostController extends Controller
{
	public function index() {
		// Verifica qual o parâmetro get para decidir qual filtro usar
		if(!request('order')) {
			return redirect('/?order=news');
		} else if(request('order') === 'news') {
			$posts = Post::with(['user', 'tags'])
				         ->withCount('comments')
						 ->latest('id')
						 ->get();
		} else if(request('order') === 'likes') {
			$posts = Post::with(['user', 'tags'])
						 ->withCount('comments')
						 ->orderBy('statistics->likes')
						 ->get();
		} else if(request('order') === 'views') {
			$posts = Post::with(['user', 'tags'])
						 ->withCount('comments')
						 ->latest('statistics->views')
						 ->get();
		}
		
		return view('index', [
			'posts' => $posts
		]);
	}
	
	public function search() {
		return view('posts.search', [
			'posts' => Post::with(['user', 'tags'])
						   ->withCount('comments')
						   ->where('title', 'LIKE', '%' . request('q') . '%')
						   ->latest('id')
						   ->get()
		]);
	}
	
	public function show(User $user, Post $post) {
		// Incrementa uma view quando alguém entra no post
		$post_incremented = $post->statistics;
		$post_incremented['views']++;
		
		// Desativa os timestamps, para o updated_at não ser alterado apenas por aumentar view
		$post->timestamps = false;
		$post->update([
			'statistics' => $post_incremented
		]);
		$post->timestamps = true;
		
		return view('posts.show', [
			'post' => Post::with(['user', 'tags'])
						  ->findOrFail($post->id),
			'comments' => Comment::with(['post', 'user'])
								  ->where('post_id', '=', $post->id)
								  ->latest('id')
								  ->get()
		]);
	}
	
	public function create() {
		return view('posts.create', [
			'tags' => Tag::all()
		]);
	}
	
	public function store() {
		$validation = request()->validate([
			'title' => ['required'],
			'wallpaper' => ['nullable', 'image'],
			'text' => ['required'],
			'tag' => ['nullable']
		]);
		$validation['user_id'] = Auth::user()->id;
		$validation['statistics'] = [
			'likes' => [],
			'deslikes' => [], 
			'views' => 0
		];
		
		if(request()->hasFile('wallpaper')) {
			$validation['wallpaper'] = 'storage/' . request()->wallpaper->store('post_wallpapers', 'public');
		}
		
		// Cria o post com todos os dados da validação excepto as tags, para as tags levar attach
		$post = Post::create(Arr::except($validation, 'tag'));
		$post->tags()->attach($validation['tag'] ?? []);
		
		return redirect('/user/' . $post->user->nick . '/post/' . $post->id);
	}
	
	public function edit(User $user, Post $post) {
		if($user->id !== Auth::user()->id) {
			abort(403, 'Access not authorizated.');
		}
		
		return view('posts.edit', [
			'post' => $post,
			'tags' => Tag::all()
		]);
	}
	
	public function update(User $user, Post $post) {
		$validation = request()->validate([
			'title' => ['required'],
			'wallpaper' => ['nullable', 'image'],
			'text' => ['required'],
			'tag' => ['nullable']
		]);
		
		// Verifica se o utilizador meteu algum wallpaper, caso não tenha metido significa que não quer trocar o wallpaper e fica o mesmo
		if(request()->hasFile('wallpaper')) {
			// Verifica se o utilizador já tem algum wallpaper, para eliminar o antigo e meter o novo, e evita eliminar o wallpaper default
			if($post->wallpaper && ($post->wallpaper !== 'storage/post_wallappers/factory.png')) {
				Storage::disk('public')->delete(Str::of($post->wallpaper)->after('storage/'));
			}
			$validation['wallpaper'] = 'storage/' . request()->wallpaper->store('post_wallpapers', 'public');
		}
		
		// Cria o post com todos os dados da validação excepto as tags, para as tags levar sync
		$post->update(Arr::except($validation, 'tag'));
		$post->tags()->sync($validation['tag'] ?? []);
		
		return redirect('/user/' . Auth::user()->nick . '/post/' . $post->id);
	}
	
	public function destroy(User $user, Post $post) {
		if($post->wallpaper && ($post->wallpaper !== 'storage/post_wallappers/factory.png')) {
			Storage::disk('public')->delete(Str::of($post->wallpaper)->after('storage/'));
		}
		
		// Não removo as tags por código, porque a própria base de dados já elimina automáticamente por causa do cascadeOnDelete
		
		$post->delete();
		
		return redirect('/user/' . Auth::user()->nick);
	}
	
	public function like(Post $post) {
		$post_liked = $post->statistics;
		
		// Verifica se já deu like ou não, para definir se mete ou remove o like, uma espécie de toggle com php
		if(in_array(Auth::user()->id, $post_liked['likes'])) {
			unset($post_liked['likes'][array_search(Auth::user()->id, $post_liked['likes'])]);
		} else {
			// Se não tiver like, vai verificar se tem ou não deslike para remover caso tenha, e não ter like e deslike ao mesmo tempo
			if(in_array(Auth::user()->id, $post_liked['deslikes'])) {
				unset($post_liked['deslikes'][array_search(Auth::user()->id, $post_liked['deslikes'])]);
			}
			$post_liked['likes'][] = Auth::user()->id;
		}
		
		// Desativo o timestamps para evitar que o updated_at seja alterado e não estar a aparecer que o post foi alterado apenas por causa de um like
		$post->timestamps = false;
		$post->update([
			'statistics' => $post_liked
		]);
		$post->timestamps = true;
		
		return redirect('/');
	}
	
	public function deslike(Post $post) {
		$post_desliked = $post->statistics;
		
		// Verifica se já deu deslike ou não, para definir se mete ou remove o deslike, uma espécie de toggle com php
		if(in_array(Auth::user()->id, $post_desliked['deslikes'])) {
			unset($post_desliked['deslikes'][array_search(Auth::user()->id, $post_desliked['deslikes'])]);
		} else {
			// Se não tiver deslike, vai verificar se tem ou não like para remover caso tenha, e não ter deslike e like ao mesmo tempo
			if(in_array(Auth::user()->id, $post_desliked['likes'])) {
				unset($post_desliked['likes'][array_search(Auth::user()->id, $post_desliked['likes'])]);
			}
			$post_desliked['deslikes'][] = Auth::user()->id;
		}
		
		// Desativo o timestamps para evitar que o updated_at seja alterado e não estar a aparecer que o post foi alterado apenas por causa de um deslike
		$post->timestamps = false;
		$post->update([
			'statistics' => $post_desliked
		]);
		$post->timestamps = true;
		
		return redirect('/');
	}
}
