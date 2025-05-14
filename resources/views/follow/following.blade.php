<x-layout>
	@if(empty($users))
		<div class="h-100 flex justify-center items-center">
			<h1 class="text-4xl font-bold">This user isn't following none!</h1>
		</div>
	@else
		<h1 class="text-3xl">Users that {{ request('user')->nick }} follows </h1>
		@foreach($users as $user)
			<div class="card bg-white md:w-100 max-w-100 h-20 shadow-sm hover:shadow-md p-5 rounded-xl flex flex-col space-y-3 opacity-0 translate-y-10 transition-all duration-700 ease-out">
				<div class="flex space-x-2">
					<a href="/user/{{ $user->nick }}"><img src="{{ asset($user->photo) }}" class="w-11 h-auto"></a>
					<div>
						<div class="flex space-x-2">
							<p class="font-semibold"><a href="/user/{{ $user->nick }}">{{ $user->name }}</a></p>
							<p class="text-gray-700 mb-1"><a href="/user/{{ $user->nick }}">{{ "@" . $user->nick }}</a></p>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	@endif
</x-layout>
