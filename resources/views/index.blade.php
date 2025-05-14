<x-layout>
	@if($posts->isEmpty())
		<div class="h-100 flex justify-center items-center">
			<h1 class="text-4xl font-bold">It wasn't found any posts!</h1>
		</div>
	@else
		<div class="flex space-x-2 mr-110">
			<x-button-filter filter="news">Recents</x-button-filter>
			<x-button-filter filter="likes">Top Likes</x-button-filter>
			<x-button-filter filter="views">Top Views</x-button-filter>
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
	@endif
</x-layout>
