<x-layout>
	<div class="card md:w-140 max-w-140 shadow-sm hover:shadow-md bg-white rounded-xl opacity-0 translate-y-10 transition-all duration-700 ease-out">
		<h1 class="text-3xl font-bold text-center mt-20">Change Password</h1>
		<form action="/profile/change_password" method="POST" class="flex flex-col items-center mx-20 mt-10 space-y-5">
			@csrf
			@method('PATCH')
			<div class="flex flex-col space-y-1">
				<label for="current_password" class="text-xl">Current Password:</label>
				<input type="password" name="current_password" placeholder="Current Password..." class="w-100 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
				@error('current_password')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="password" class="text-xl">New Password:</label>
				<input type="password" name="password" placeholder="New Password..." class="w-100 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
				@error('password')
					<p class="text-red-500">{{ $message }}</p>
				@enderror
			</div>
			<div class="flex flex-col space-y-1">
				<label for="password_confirmation" class="text-xl">Confirm New Password:</label>
				<input type="password" name="password_confirmation" placeholder="Confirm Password..." class="w-100 h-10 bg-gray-200 placeholder-gray-600 pl-3 border">
			</div>
			<button type="Submit" class="cursor-pointer w-50 h-15 bg-blue-400 text-white text-lg mx-65 mt-2 mb-10 rounded-full">Change Password</button>
		</form>
	</div>
</x-layout>
