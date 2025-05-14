@props(['photo', 'name', 'nick', 'date_link', 'date', 'hour', 'created_at', 'updated_at', 'comment' => false, 'm' => 0])

<div class="flex justify-between">
	<div class="flex space-x-2 m-{{ $m }}">
		{{-- Foto de perfil --}}
		<a href="/user/{{ $nick }}"><img src="{{ asset($photo) }}" class="w-11 h-auto"></a>
		<div>
			<div class="flex space-x-2">
				{{-- Nome do User --}}
				<p class="font-semibold"><a href="/user/{{ $nick }}">{{ $name }}</a></p>
				{{-- Nick do User --}}
				<p class="text-gray-700 mb-1"><a href="/user/{{ $nick }}">{{ "@" . $nick }}</a></p>
			</div>
			<div class="flex space-x-2 text-sm font-extralight">
				{{-- Vai verificar se o component está a ser utilizado num post ou num comentário para decidir qual mensagem mais adequada a utilizar-se --}}
				@if(!$comment)
					{{-- Data de criação do Post --}}
					<p>Posted on <a href="/posts/date/{{ $date_link }}">{{ $date }}</a> at {{ $hour }}</p>
					{{-- Verifica de a data de criação do Post é diferente ou não da data de alteração do Post para mostrar se o Post foi editado ou não --}}
					@if($created_at !== $updated_at)
						<span class="text-xs font-bold">.</span>					
						<p>Edited</p>
					@endif
				@else
					{{-- Data de criação do comentário --}}
					<p>Commented on {{ $date }} at {{ $hour }}</p>
					{{-- Verifica de a data de criação do comentário é diferente ou não da data de alteração do comentário para mostrar se o comentário foi editado ou não --}}
					@if($created_at !== $updated_at)
						<span class="text-xs font-bold">.</span>					
						<p>Edited</p>
					@endif
				@endif
			</div>
		</div>
	</div>
</div>
