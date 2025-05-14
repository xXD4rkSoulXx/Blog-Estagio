<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CommentController;

Route::get('/', [PostController::class, 'index']); // Página Principal
Route::get('/search', [PostController::class, 'search']); // Procurar Post específico
Route::get('/user/{user:nick}/post/{post}', [PostController::class, 'show']); // Detalhes do Post
Route::get('/post/create', [PostController::class, 'create'])->middleware('auth'); // Formulário de criar post
Route::post('/post/create', [PostController::class, 'store'])->middleware('auth'); // Criar o post para a base de dados
Route::get('/user/{user:nick}/post/{post}/edit', [PostController::class, 'edit'])->middleware('auth'); // Formulário de editar o post
Route::patch('/user/{user:nick}/post/{post}/edit', [PostController::class, 'update'])->middleware('auth'); // Editar o post para a base de dados
Route::delete('/user/{user:nick}/post/{post}', [PostController::class, 'destroy'])->middleware('auth'); // Eliminar o post
Route::patch('/like/{post}', [PostController::class, 'like'])->middleware('auth'); // Dar like no post
Route::patch('/deslike/{post}', [PostController::class, 'deslike'])->middleware('auth'); // Dar deslike no post

// A parte de aparecer os comentários e criar comentário, estão integrados na página de detalhes do Post
Route::post('/user/{user:nick}/post/{post}/comment', [CommentController::class, 'store']); // Criar comentário na base de dados
Route::get('/user/{user:nick}/post/{post}/comment/{comment}/edit', [CommentController::class, 'edit'])->middleware('auth'); // Formulário de editar o comentário
Route::patch('/user/{user:nick}/post/{post}/comment/{comment}/edit', [CommentController::class, 'update'])->middleware('auth'); // Editar o comentário na base de dados
Route::delete('/user/{user:nick}/post/{post}/comment/{comment}', [CommentController::class, 'destroy'])->middleware('auth'); // Eliminar o comentário
Route::patch('/user/{user:nick}/post/{post}/comment/{comment}/like', [CommentController::class, 'like'])->middleware('auth'); // Dar like no comentário
Route::patch('/user/{user:nick}/post/{post}/comment/{comment}/deslike', [CommentController::class, 'deslike'])->middleware('auth'); // Dar deslike no comentário

Route::get('/tag/{tag:name}', [TagController::class, 'search']); // Procurar os posts duma tag específica

Route::get('/posts/date/{date}', [DateController::class, 'search']); // Procurar os posts duma data específica

Route::get('/user/{user:nick}', [UserController::class, 'show']); // Página de ver o perfil
Route::get('/register', [UserController::class, 'create'])->middleware('guest'); // Formulário de criar conta
Route::post('/register', [UserController::class, 'store'])->middleware('guest'); // Criar conta na base de dados
Route::get('/profile/edit', [UserController::class, 'edit'])->middleware('auth'); // Formulário de editar conta
Route::patch('/profile/edit', [UserController::class, 'update'])->middleware('auth'); // Editar conta na base de dados
Route::get('/profile/change_password', [UserController::class, 'changePasswordPage'])->middleware('auth'); // Formulário de editar password
Route::patch('/profile/change_password', [UserController::class, 'changePassword'])->middleware('auth'); // Editar password na base de dados
Route::patch('/user/{user:nick}/follow', [UserController::class, 'follow'])->middleware('auth'); // Dar follow no user
Route::patch('/user/{user:nick}/unfollow', [UserController::class, 'unfollow'])->middleware('auth'); // Dar unfollow no user
Route::get('/user/{user:nick}/following', [UserController::class, 'following'])->middleware('auth'); // Ver quem o user segue
Route::get('/user/{user:nick}/followers', [UserController::class, 'followers'])->middleware('auth'); // Ver quem segue o user

Route::get('/login', [SessionController::class, 'create'])->middleware('guest'); // Formulário de login
Route::post('/login', [SessionController::class, 'store'])->middleware('guest'); // Fazer login
Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth'); // Fazer logout
