@props(['filter'])

<a href="/?order={{ $filter }}">
	{{-- Verifica se o botão é o botão da página filtrada ou não, para dar aquele ar de active --}}
	<button class="{{ request('order') === $filter ? 'bg-gray-500' : 'bg-black' }} card cursor-pointer w-25 h-12 text-white shadow-sm hover:shadow-md opacity-0 translate-y-10 transition-all duration-700 ease-out">
		{{ $slot }}
	</button>
</a>
