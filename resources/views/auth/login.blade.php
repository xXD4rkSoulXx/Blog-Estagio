<x-layout>
	<div class="card md:w-140 max-w-140 shadow-sm hover:shadow-md bg-white rounded-xl opacity-0 translate-y-10 transition-all duration-700 ease-out">
		<h1 class="text-3xl font-bold text-center mt-20">Log In</h1>
		<form action="/login" method="POST" class="flex flex-col items-center mx-20 mt-10 space-y-5">
			@csrf
			<div class="flex flex-col space-y-1">
				<label for="email" class="text-xl">Email:</label>
				<input type="email" name="email" placeholder="Email" value="{{ old('email') }}" class="w-100 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
				@error('email')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="Password" class="text-xl">Password:</label>
				<input type="password" name="password" placeholder="Password" class="w-100 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
				@error('password')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<button type="Submit" class="cursor-pointer w-30 h-15 bg-blue-400 text-white text-lg mx-65 mt-2 mb-10 rounded-full">Log In</button>
		</form>
	</div>
</x-layout>
