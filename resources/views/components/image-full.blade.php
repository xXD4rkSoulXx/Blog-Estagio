@props(['image'])

<div class="image-full fixed top-0 left-0 z-3 w-full h-full bg-black/50 hidden">
	{{-- Ícone da cruz para fechar o Pop-Up --}}
	<div class="close-button flex justify-end mt-5 mr-5">
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-20 cursor-pointer">
		  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
		</svg>
	</div>
	{{-- Imagem aumentada --}}
	<div class="image w-full h-full flex justify-center items-center -mt-20">
		<img src="{{ asset($image) }}" class="w-100 h-auto">
	</div>
</div>