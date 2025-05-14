<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function store(User $user, Post $post) {
		// Verifica se o user está autenticado ou não para evitar que alguém não autenticado logue
		if(!auth()->check()) {
			throw ValidationException::withMessages([
				'text' => 'You need to do login for can comment.'
			]);
		}
		
		$validation = request()->validate([
			'text' => ['required']
		]);
		$validation['post_id'] = $post->id;
		$validation['user_id'] = Auth::user()->id;
		$validation['statistics'] = [
			'likes' => [],
			'deslikes' => []
		];
		
		Comment::create($validation);
		
		return redirect('/user/' . $user->nick . '/post/' . $post->id . '#commentZone');
	}
	
	public function edit(User $user, Post $post, Comment $comment) {
		// Evita que utilizadores que não fizeram o comentário possam editá-lo
		if($comment->user_id !== Auth::user()->id) {
			abort(403, 'Access not authorizated.');
		}
		
		return view('comments.edit', [
			'comment' => $comment
		]);
	}
	
	public function update(User $user, Post $post, Comment $comment) {
		$validation = request()->validate([
			'text' => ['required']
		]);
		
		$comment->update($validation);
		
		return redirect('/user/' . $user->nick . '/post/' . $post->id . '#commentZone');
	}
	
	public function destroy(User $user, Post $post, Comment $comment) {
		$comment->delete();
		
		return redirect('/user/' . $user->nick . '/post/' . $post->id . '#commentZone');
	}
	
	public function like(User $user, Post $post, Comment $comment) {
		$comment_liked = $comment->statistics;
		
		// Verifica se já deu like ou não, para definir se mete ou remove o like, uma espécie de toggle com php
		if(in_array(Auth::user()->id, $comment_liked['likes'])) {
			unset($comment_liked['likes'][array_search(Auth::user()->id, $comment_liked['likes'])]);
		} else {
			// Se não tiver like, vai verificar se tem ou não deslike para remover caso tenha, e não ter like e deslike ao mesmo tempo
			if(in_array(Auth::user()->id, $comment_liked['deslikes'])) {
				unset($comment_liked['deslikes'][array_search(Auth::user()->id, $comment_liked['deslikes'])]);
			}
			$comment_liked['likes'][] = Auth::user()->id;
		}
		
		// Desativo o timestamps para evitar que o updated_at seja alterado e não estar a aparecer que o comentário foi alterado apenas por causa de um like
		$comment->timestamps = false;
		$comment->update([
			'statistics' => $comment_liked
		]);
		$comment->timestamps = true;
		
		return redirect('/user/' . $user->nick . '/post/' . $post->id . '#commentZone');
	}
	
	public function deslike(User $user, Post $post, Comment $comment) {
		$comment_desliked = $comment->statistics;
		
		// Verifica se já deu deslike ou não, para definir se mete ou remove o deslike, uma espécie de toggle com php
		if(in_array(Auth::user()->id, $comment_desliked['deslikes'])) {
			unset($comment_desliked['deslikes'][array_search(Auth::user()->id, $comment_desliked['deslikes'])]);
		} else {
			// Se não tiver deslike, vai verificar se tem ou não like para remover caso tenha, e não ter deslike e like ao mesmo tempo
			if(in_array(Auth::user()->id, $comment_desliked['likes'])) {
				unset($comment_desliked['likes'][array_search(Auth::user()->id, $comment_desliked['likes'])]);
			}
			$comment_desliked['deslikes'][] = Auth::user()->id;
		}
		
		// Desativo o timestamps para evitar que o updated_at seja alterado e não estar a aparecer que o comentário foi alterado apenas por causa de um deslike
		$comment->timestamps = false;
		$comment->update([
			'statistics' => $comment_desliked
		]);
		$comment->timestamps = true;
		
		return redirect('/user/' . $user->nick . '/post/' . $post->id . '#commentZone');
	}
}
