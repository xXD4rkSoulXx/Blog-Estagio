<x-layout>
	<div class="card md:w-200 max-w-200 shadow-sm hover:shadow-md bg-white rounded-xl opacity-0 translate-y-10 transition-all duration-700 ease-out">
		<h1 class="text-3xl font-bold text-center mt-20">Edit Comment</h1>
		<form action="/user/{{ request('post')->user->nick }}/post/{{ request('post')->id }}/comment/{{ request('comment')->id }}/edit" method="POST" enctype="multipart/form-data" class="mx-20 mt-10 space-y-5">
			@csrf
			@method('PATCH')
			<div class="flex flex-col space-y-1">
				<label for="text" class="text-xl">Comment:</label>
				<textarea name="text" placeholder="The comment of post..." class="w-160 bg-gray-200 placeholder-gray-600 p-3 border resize-none">{{ old('text', $comment->text) }}</textarea>
				@error('text')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<button type="Submit" class="cursor-pointer w-30 h-15 bg-blue-400 text-white text-lg mx-65 mt-2 mb-10 rounded-full">Edit</button>
		</form>
	</div>
</x-layout>
