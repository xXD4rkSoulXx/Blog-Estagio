<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function show(User $user) {
		return view('users.show', [
			'user' => $user,
			'posts' => Post::with(['user', 'tags'])
						   ->withCount('comments')
						   ->where('user_id', '=', $user->id)
						   ->latest('id')
						   ->get()
		]);
	}
	
	public function create() {
		return view('auth.register');
	}
	
	public function store() {
		$validation = request()->validate([
			'name' => ['required', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
			'nick' => ['required', 'unique:users,nick', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'email' => ['required', 'email', 'unique:users,email'],
			'password' => ['required', Password::default(), 'confirmed'],
			'photo' => ['nullable', 'image'],
			'wallpaper' => ['nullable', 'image'],
			'birth' => ['nullable', 'date'],
			'bio' => ['nullable'],
			'facebook' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'instagram' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'youtube' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'twitter' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'github' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'linkedin' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/']
		]);
		// Remove os espaços e converte para os nomes para formato norma, de dIoGo para Diogo
		$validation['name'] = trim(mb_convert_case($validation['name'], MB_CASE_TITLE, "UTF-8"));
		$validation['nick'] = trim($validation['nick']);
		$validation['follows'] = [
			'followers' => [],
			'following' => []
		];
		
		// Verifica se meteu alguma imagem, se não mete a imagem default
		if(request()->hasFile('photo')) {
			$validation['photo'] = 'storage/' . request()->photo->store('profile_photos', 'public');
		} else {
			$validation['photo'] = 'storage/profile_photos/default.png';
		}
		// Verifica se meteu alguma imagem, se não mete a imagem default
		if(request()->hasFile('wallpaper')) {
			$validation['wallpaper'] = 'storage/' . request()->wallpaper->store('profile_wallpapers', 'public');
		} else {
			$validation['wallpaper'] = 'storage/profile_wallpapers/default.png';
		}
		
		if(!empty($validation['facebook'])) {
			$validation['facebook'] = 'https://www.facebook.com/' . trim($validation['facebook']);
		}
		if(!empty($validation['instagram'])) {
			$validation['instagram'] = 'https://www.instagram.com/' . trim($validation['instagram']);
		}
		if(!empty($validation['youtube'])) {
			$validation['youtube'] = 'https://www.youtube.com/' . trim($validation['youtube']);
		}
		if(!empty($validation['twitter'])) {
			$validation['twitter'] = 'https://www.x.com/' . trim($validation['twitter']);
		}
		if(!empty($validation['github'])) {
			$validation['github'] = 'https://www.github.com/' . trim($validation['github']);
		}
		if(!empty($validation['linkedin'])) {
			$validation['linkedin'] = 'https://www.linkedin.com/' . trim($validation['linkedin']);
		}
		
		$user = User::create($validation);
		
		Auth::login($user);
		
		return redirect('/');
	}
	
	public function edit() {
		return view('users.edit', [
			'user' => Auth::user()
		]);
	}
	
	public function update() {
		$validation = request()->validate([
			'name' => ['required', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
			'nick' => ['required', Rule::unique('users', 'nick')->ignore(Auth::id()), 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
			'photo' => ['nullable', 'image'],
			'wallpaper' => ['nullable', 'image'],
			'birth' => ['nullable', 'date'],
			'bio' => ['nullable'],
			'facebook' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'instagram' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'youtube' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'twitter' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'github' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/'],
			'linkedin' => ['nullable', 'regex:/^[a-zA-Z0-9_.-]+$/']
		]);
		$validation['name'] = trim(mb_convert_case($validation['name'], MB_CASE_TITLE, "UTF-8"));
		$validation['nick'] = trim($validation['nick']);
		
		if(request()->hasFile('photo')) {
			// Verifica se a imagem alterada não é a default para não eliminar a imagem default
			if(Auth::user()->photo !== 'storage/profile_photos/default.png') {
				// Retira o storage/ da string para eliminar o caminho correto
				Storage::disk('public')->delete(Str::of(Auth::user()->photo)->after('storage/'));
			}
			$validation['photo'] = 'storage/' . request()->photo->store('profile_photos', 'public');
		}
		if(request()->hasFile('wallpaper')) {
			// Verifica se a imagem alterada não é a default para não eliminar a imagem default
			if(Auth::user()->wallpaper !== 'storage/profile_wallpapers/default.png') {
				// Retira o storage/ da string para eliminar o caminho correto
				Storage::disk('public')->delete(Str::of(Auth::user()->wallpaper)->after('storage/'));
			}
			$validation['wallpaper'] = 'storage/' . request()->wallpaper->store('profile_wallpapers', 'public');
		}
		
		if(!empty($validation['facebook'])) {
			$validation['facebook'] = 'https://www.facebook.com/' . trim($validation['facebook']);
		}
		if(!empty($validation['instagram'])) {
			$validation['instagram'] = 'https://www.instagram.com/' . trim($validation['instagram']);
		}
		if(!empty($validation['youtube'])) {
			$validation['youtube'] = 'https://www.youtube.com/' . trim($validation['youtube']);
		}
		if(!empty($validation['twitter'])) {
			$validation['twitter'] = 'https://www.x.com/' . trim($validation['twitter']);
		}
		if(!empty($validation['github'])) {
			$validation['github'] = 'https://www.github.com/' . trim($validation['github']);
		}
		if(!empty($validation['linkedin'])) {
			$validation['linkedin'] = 'https://www.linkedin.com/' . trim($validation['linkedin']);
		}
		
		Auth::user()->update($validation);
		
		return redirect('/user/' . Auth::user()->nick);
	}
	
	public function changePasswordPage() {
		return view('users.change_password');
	}
	
	public function changePassword() {
		$validation = request()->validate([
			'current_password' => ['required'],
			'password' => ['required', Password::default(), 'confirmed']
		]);
		
		if(!Hash::check($validation['current_password'], Auth::user()->password)) {
			throw ValidationException::withMessages([
				'current_password' => 'The current password is wrong.'
			]);
		}
		
		Auth::user()->update([
			'password' => Hash::make($validation['password'])
		]);
		
		return redirect('/');
	}
	
	public function follow(User $user) {
		$following = Auth::user()->follows;
		$followers = $user->follows;
		
		$following['following'][] = $user->id;
		$followers['followers'][] = Auth::user()->id;
		
		$auth = User::find(Auth::user()->id);
		$auth->update([
			'follows' => $following
		]);
		$user->update([
			'follows' => $followers
		]);
		
		return redirect('/user/' . $user->nick);
	}
	
	public function unfollow(User $user) {
		$following = Auth::user()->follows;
		$followers = $user->follows;
		
		// Procura o id do user está no array dos following e retorna o id caso encontre para eliminar
		unset($following['following'][array_search($user->id, $following)]);
		unset($followers['followers'][array_search(Auth::user()->id, $followers)]);
		
		$auth = User::find(Auth::user()->id);
		$auth->update([
			'follows' => $following
		]);
		$user->update([
			'follows' => $followers
		]);
		
		return redirect('/user/' . $user->nick);
	}
	
	public function following(User $user) {
		$followings = $user->follows;
		
		// Procura todos os users que segue para mostrar
		foreach($followings['following'] as $following) {
			$users[] = User::find($following);
		}
		
		return view('follow.following', [
			'users' => $users ?? []
		]);
	}
	
	public function followers(User $user) {
		$followers = $user->follows;
		
		// Procura todos os users que seguem-lhe para mostrar
		foreach($followers['followers'] as $follower) {
			$users[] = User::find($follower);
		}
		
		return view('follow.followers', [
			'users' => $users ?? []
		]);
	}
}
