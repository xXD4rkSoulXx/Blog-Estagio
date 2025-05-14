<x-layout>
	<div class="flex items-center space-x-7 text-3xl font-bold self-start mx-100">
		<div class="w-20 h-20 bg-black text-white flex justify-center items-center text-[70px]">
			#
		</div>
		<h1>Searching for tags with {{ request('tag')->name }}</h1>
	</div>
	@foreach($posts as $post)
		<x-post-card
			id="{{ $post->id }}"
			:user="$post->user"
			date_link="{{ $post->created_at->format('d-m-Y') }}"
			date="{{ $post->created_at->format('M d, Y') }}"
			hour="{{ $post->created_at->format('H:i') }}"
			:created_at="$post->created_at"
			:updated_at="$post->updated_at"
			title="{!! $post->title !!}"
			text="{!! $post->text !!}"
			likes="{{ count($post->statistics['likes']) }}"
			deslikes="{{ count($post->statistics['deslikes']) }}"
			:statistics="$post->statistics"
			numComments="{{ $post->comments_count }}"
			views="{{ $post->statistics['views'] }}"
			:tags="$post->tags"
		/>
	@endforeach
</x-layout>
