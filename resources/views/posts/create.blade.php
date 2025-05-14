<x-layout>
	<div class="card md:w-200 max-w-200 shadow-sm hover:shadow-md bg-white rounded-xl opacity-0 translate-y-10 transition-all duration-700 ease-out">
		<h1 class="text-3xl font-bold text-center mt-20">Create a post</h1>
		<form action="/post/create" method="POST" enctype="multipart/form-data" class="mx-20 mt-10 space-y-5">
			@csrf
			<div class="flex flex-col space-y-1">
				<label for="title" class="text-xl">Title:</label>
				<input type="text" name="title" placeholder="The title of post..." value="{{ old('title') }}" class="w-150 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
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
				<textarea name="text" id="editor" placeholder="The body of post..." class="w-150 h-100 bg-gray-200 placeholder-gray-600 p-3 border resize-none">{{ old('text') }}</textarea>
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
	{{-- Caso a validação falhe, verifica se a tag está dentro do array das tags selecionadas para preencher de novo caso,
		 Se a validação não tiver falho, mete por default um array vazio para não preencher tag nenhuma --}}		
								<input type="checkbox" name="tag[]" value="{{ $tag->id }}"
								@if(in_array($tag->id, old('tag', [])))
									checked
								@endif
								class="w-5 h-5 bg-gray-200 mt-1 border">
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<button type="Submit" class="cursor-pointer w-30 h-15 bg-blue-400 text-white text-lg mx-65 mt-2 mb-10 rounded-full">Create</button>
		</form>
	</div>
</x-layout>