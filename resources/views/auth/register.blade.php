<x-layout>
	<div class="card md:w-200 max-w-200 shadow-sm hover:shadow-md bg-white rounded-xl opacity-0 translate-y-10 transition-all duration-700 ease-out">
		<h1 class="text-3xl font-bold text-center mt-20">Sign Up</h1>
		<form action="/register" method="POST" enctype="multipart/form-data" class="mx-20 mt-10 space-y-5">
			@csrf
			<div class="flex flex-col space-y-1">
				<label for="name" class="text-xl">Name:</label>
				<input type="text" name="name" placeholder="Your name..." value="{{ old('name') }}" class="w-150 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
				@error('name')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="nick" class="text-xl">Nick:</label>
				<input type="text" name="nick" placeholder="Your nick..." value="{{ old('nick') }}" class="w-150 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
				@error('nick')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="email" class="text-xl">Email:</label>
				<input type="text" name="email" placeholder="Your email..." value="{{ old('email') }}" class="w-150 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
				@error('email')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="Password" class="text-xl">Password:</label>
				<input type="password" name="password" placeholder="Password..." class="w-150 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
				@error('password')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="password_confirmation" class="text-xl">Confirm Password:</label>
				<input type="password" name="password_confirmation" placeholder="Confirm Password..." class="w-150 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
			</div>
			<div class="flex flex-col space-y-1">
				<label for="photo" class="text-xl">Photo:</label>
				<input type="file" name="photo" class="w-90 h-10 bg-gray-200 pl-3 pt-2 border">
				@error('photo')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="wallpaper" class="text-xl">Wallpaper:</label>
				<input type="file" name="wallpaper" class="w-90 h-10 bg-gray-200 pl-3 pt-2 border">
				@error('wallpaper')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="birth" class="text-xl">Birth Date:</label>
				<input type="date" name="birth" placeholder="Your birth date..." value="{{ old('birth') }}" class="w-35 h-10 bg-gray-200 pl-3 border">
			</div>
			<div class="flex flex-col space-y-1">
				<label for="bio" class="text-xl">Biography:</label>
				<textarea name="bio" placeholder="Your biography..." class="w-150 h-100 bg-gray-200 placeholder-gray-600 p-3 border resize-none">{{ old('bio') }}</textarea>
			</div>
			<h1 class="text-2xl mt-10">Social Medias:</h1>
			<div class="flex flex-col space-y-1">
				<div class="flex space-x-1">
					<p class="text-lg">www.facebook.com/</p>
					<input type="text" name="facebook" placeholder="Your facebook nick..." value="{{ old('facebook') }}" class="w-53 h-8 bg-gray-200 placeholder-gray-600 text-lg pl-3 border">
				</div>
				@error('facebook')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<div class="flex space-x-1">
					<p class="text-lg">www.instagram.com/</p>
					<input type="text" name="instagram" placeholder="Your instagram nick..." value="{{ old('instagram') }}" class="w-53 h-8 bg-gray-200 placeholder-gray-600 text-lg pl-3 border">
				</div>
				@error('instagram')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<div class="flex space-x-1">
					<p class="text-lg">www.youtube.com/</p>
					<input type="text" name="youtube" placeholder="Your youtube nick..." value="{{ old('youtube') }}" class="w-53 h-8 bg-gray-200 placeholder-gray-600 text-lg pl-3 border">
				</div>
				@error('youtube')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<div class="flex space-x-1">
					<p class="text-lg">www.x.com/</p>
					<input type="text" name="twitter" placeholder="Your twitter nick..." value="{{ old('twitter') }}" class="w-53 h-8 bg-gray-200 placeholder-gray-600 text-lg pl-3 border">
				</div>
				@error('twitter')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<div class="flex space-x-1">
					<p class="text-lg">www.github.com/</p>
					<input type="text" name="github" placeholder="Your github nick..." value="{{ old('github') }}" class="w-53 h-8 bg-gray-200 placeholder-gray-600 text-lg pl-3 border">
				</div>
				@error('github')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<div class="flex space-x-1">
					<p class="text-lg">www.linkedin.com/</p>
					<input type="text" name="linkedin" placeholder="Your linkedin nick..." value="{{ old('linkedin') }}" class="w-53 h-8 bg-gray-200 placeholder-gray-600 text-lg pl-3 border">
				</div>
				@error('linkedin')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<button type="Submit" class="cursor-pointer w-30 h-15 bg-blue-400 text-white text-lg mx-65 mt-2 mb-10 rounded-full">Sign Up</button>
		</form>
	</div>
</x-layout>
