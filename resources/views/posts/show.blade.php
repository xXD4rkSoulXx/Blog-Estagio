@if($post->wallpaper)
	<x-image-full image="{{ $post->wallpaper }}" />
@endif
<x-layout>
	{{-- Zona do post --}}
	<div class="card md:w-200 max-w-200 shadow-sm hover:shadow-md bg-white py-20 rounded-xl opacity-0 translate-y-10 transition-all duration-700 ease-out">
		{{-- Título do Post --}}
		<h1 class="text-4xl text-center font-bold">{{ $post->title }}</h1>
		{{-- Perfil do user do post --}}
		<x-profile-zone
			photo="{{ $post->user->photo }}"
			name="{{ $post->user->name }}"
			nick="{{ $post->user->nick }}" 
			date_link="{{ $post->created_at->format('d-m-Y') }}"
			date="{{ $post->created_at->format('M d, Y') }}"
			hour="{{ $post->created_at->format('H:i') }}"
			:created_at="$post->created_at"
			:updated_at="$post->updated_at"
			m="10"
		/>
		{{-- Verifica se o post tem algum wallpaper ou não, para caso não estiver, não aparecer aquela imagem não encontrada --}}
		@if($post->wallpaper)
			<img src="{{ asset($post->wallpaper) }}" class="increase-button md:w-full max-w-full h-auto cursor-pointer">
		@endif
		<div class="text-xl mx-10 mt-7">
			{{-- Texto do post --}}
			{{ $post->text }}
			{{-- Mostra todas as tags do post --}}
			@foreach($post->tags as $tag)
				<a href="/tag/{{ $tag->name }}"><i class="text-cyan-400 font-medium">#{{ $tag->name }}</i></a>
			@endforeach
		</div>
	</div>
	{{-- Zona dos comentários --}}
	<div id="commentZone" class="card md:w-200 max-w-200 shadow-sm hover:shadow-md bg-white py-20 px-10 rounded-xl opacity-0 translate-y-10 transition-all duration-700 ease-out">
		<h1 class="text-2xl font-medium mb-5">Comments</h1>
		<div class="flex space-x-2 mb-10">
			{{-- Se o user não estiver autenticado, não aparece a opção de clicar e parar no perfil do user --}}
			@auth
				<a href="/user/{{ Auth::user()->nick }}">
			@endauth
					<a><img src="{{ asset($post->user->photo) }}" class="w-11 h-auto"></a>
			@auth
				</a>
			@endauth
			{{-- Zona de comentar --}}
			<form action="/user/{{ $post->user->nick }}/post/{{ $post->id }}/comment" method="POST" class="w-full flex flex-col">
				@csrf
				<textarea name="text" placeholder="Your comment..." class="w-full h-30 p-2 border rounded-md resize-none"></textarea>
				{{-- Aparece mensagem de erro caso o comentário esteja vazio ou caso seja alguém não autenticado a querer autenticar-se a informar que precisa fazer login para comentar --}}
				@error('text')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
				<button tyoe="submit" class="w-25 h-10 bg-blue-400 text-white mt-3 rounded-sm self-end cursor-pointer">Comment</button>
			</form>
		</div>
		<hr>
		{{-- Comentários do post --}}
		@if($comments->isEmpty())
			<div class="h-100 flex justify-center items-center">
				<h1 class="text-4xl font-bold">This post doesn't have comments!</h1>
			</div>
		@else
			@foreach($comments as $comment)
				<x-comment
					post_id="{{ $post->id }}"
					id="{{ $comment->id }}"
					photo="{{ $comment->user->photo }}"
					name="{{ $comment->user->name }}"
					nick="{{ $comment->user->nick }}" 
					date_link="{{ $comment->created_at->format('d-m-Y') }}"
					date="{{ $comment->created_at->format('M d, Y') }}"
					hour="{{ $comment->created_at->format('H:i') }}"
					:created_at="$comment->created_at"
					:updated_at="$comment->updated_at"
					text="{{ $comment->text }}"
					:comment="true"
					likes="{{ count($comment->statistics['likes']) }}"
					deslikes="{{ count($comment->statistics['deslikes']) }}"
					:statistics="$comment->statistics"
				/>
			@endforeach
		@endif
	</div>
</x-layout>
