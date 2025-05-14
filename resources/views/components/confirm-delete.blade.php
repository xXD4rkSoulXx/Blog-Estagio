@props(['nick', 'id', 'comment_id' => null])

<div class="image-full fixed top-0 left-0 z-3 w-full h-full bg-black/50 hidden">
	<div class="image w-full h-full flex justify-center items-center">
		<div class="w-150 h-100 bg-white flex flex-col justify-center items-center space-y-30 rounded-xl">
			{{-- Mensagem de confirmação de eliminação --}}
			<div class="w-100 mt-20 text-5xl text-center">
				Are you sure you want to delete?
			</div>
			{{-- Zona dos botões --}}
			<div class="self-end mr-10 space-x-2">
				<button class="close-button text-lg cursor-pointer">Cancel</button>
				<button form="delete-post" class="text-lg text-red-500 cursor-pointer">Delete</button>
			</div>
		</div>
	</div>
	{{-- Forma segura de usar o método DELETE --}}
	<form id="delete-post" action="{{ $comment_id ? '/user/' . $nick . '/post/' . $id . '/comment/' . $comment_id : '/user/' . $nick . '/post/' . $id }}" method="POST" class="hidden">
		@csrf
		@method('DELETE')
	</form>
</div>