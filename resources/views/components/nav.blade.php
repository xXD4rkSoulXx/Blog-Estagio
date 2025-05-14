<nav class="w-full h-20 bg-white shadow-sm fixed top-0 left-0 z-2">
	<div class="h-full flex justify-between items-center px-10">
		{{-- Logo do site --}}
		<a href="/" class="item opacity-0 -translate-y-5 transition-all duration-500 cursor-pointer">
			<img src="{{ Vite::asset('resources/images/logo.png') }}" class="w-16 h-auto">
		</a>
		{{-- Barra de pesquisar Post --}}
		<form action="/search" method="GET" class="item flex opacity-0 -translate-y-5 transition-all duration-500">
			{{-- Caixa de texto de pesquisar --}}
			<input type="text" name="q" placeholder="Search for a post..." class="item w-100 h-13 rounded-full pl-5 pr-15 border-2">
			{{-- Divisor Vertical que se para a caixa de texto do ícone --}}
			<div class="item w-[1.5px] h-13 bg-black relative right-13"></div>
			{{-- Ícone de pesquisar --}}
			<button type="Submit" class="item relative right-11 cursor-pointer">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
					<path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
				</svg>
			</button>
		</form>
		@guest
			{{-- Se não estiver logado, aparece os botões de registar e login --}}
			<div class="item text-lg font-medium space-x-5 opacity-0 -translate-y-10 transition-all duration-500">
				<a href="/register">Sign Up</a>
				<a href="/login">Log In</a>
			</div>
		@endguest
		@auth
			{{-- Se estiver logado, aparece o botão de criar post, e as opções de perfil --}}
			<div class="item flex text-lg font-medium space-x-7 opacity-0 -translate-y-10 transition-all duration-500">
				{{-- Botão de criar Post --}}
				<div class="self-center">
					<a href="/post/create">Create Post</a>
				</div>
				{{-- Imagem de perfil do user, que vai abrir as opções de perfil --}}
				<div class="icon-profile item h-20 cursor-pointer">
					<img src="{{ asset(Auth::user()->photo) }}" class="w-12 h-auto mt-4">
				</div>
			</div>
			{{-- Opções de perfil --}}
			<div class="menu-profile w-50 bg-white text-lg shadow-sm hover:shadow-md absolute top-20 right-0 hidden">
				<ul>
					{{-- Ver perfil --}}
					<a href="/user/{{ Auth::user()->nick }}">
						<li class="px-5 py-2 hover:bg-gray-200">Your profile</li>
					</a>
					{{-- Editar o perfil --}}
					<a href="/profile/edit">
						<li class="px-5 py-2 hover:bg-gray-200">Edit profile</li>
					</a>
					{{-- Mudar a pass --}}
					<a href="/profile/change_password">
						<li class="px-5 py-2 hover:bg-gray-200">Change Password</li>
					</a>
					{{-- Logout --}}
					<button form="logout" class="w-full cursor-pointer">
						<li class="px-5 pt-2 pb-5 text-left hover:bg-gray-200">Log Out</li>
					</button>
				</ul>
				{{-- Forma mais segura de utilizar o método DELETE --}}
				<form id="logout" action="/logout" method="POST" class="hidden">
					@csrf
					@method('DELETE')
				</form>
			</div>
		@endauth
	</div>
</nav>
