<x-layout>
	<div class="card md:w-200 max-w-200 shadow-sm hover:shadow-md bg-white rounded-xl opacity-0 translate-y-10 transition-all duration-700 ease-out">
		<h1 class="text-3xl font-bold text-center mt-20">Edit Post</h1>
		<form action="/user/{{ request('post')->user->nick }}/post/{{ request('post')->id }}/edit" method="POST" enctype="multipart/form-data" class="mx-20 mt-10 space-y-5">
			@csrf
			@method('PATCH')
			<div class="flex flex-col space-y-1">
				<label for="title" class="text-xl">Title:</label>
				<input type="text" name="title" placeholder="The title of post..." value="{{ old('title', $post->title) }}" class="w-150 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
				@error('title')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="wallpaper" class="text-xl">Wallpaper:</label>
				<input type="file" name="wallpaper" class="w-90 h-10 bg-gray-200 placeholder-gray-600 pl-3 pt-2 border">
				@error('wallpaper')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="text" class="text-xl">Body:</label>
				<textarea name="text" placeholder="The body of post..." class="w-150 h-100 bg-gray-200 placeholder-gray-600 p-3 border resize-none">{{ old('text', $post->text) }}</textarea>
				@error('text')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<p class="text-xl">Tags:</p>
				<div class="flex flex-wrap space-x-5">
					@foreach($tags as $tag)
						<div class="flex flex-col space-y-1">
							<div class="flex space-x-2">
								<label for="tag[]" class="text-lg">{{ $tag->name }}</label>
	{{-- Verifica se a tag está dentro do array das tags das tags do post para pré-selecionar as tags e o utilizador não ter que selecionar de novo como
		 é opção de editar, e caso falhe na validação, verifica se a tag está dentro do array das tags selecionadas para preencher de novo caso a validação falhe --}}							
								<input type="checkbox" name="tag[]" value="{{ $tag->id }}"
								@if(in_array($tag->id, old('tag', $post->tags->pluck('id')->toArray())))
									checked
								@endif
								class="w-5 h-5 bg-gray-200 mt-1 border">
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<button type="Submit" class="cursor-pointer w-30 h-15 bg-blue-400 text-white text-lg mx-65 mt-2 mb-10 rounded-full">Edit</button>
		</form>
	</div>
</x-layout>
