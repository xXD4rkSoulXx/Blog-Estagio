<x-layout>
	<div class="flex items-center space-x-7 text-3xl font-bold self-start mx-100">
		{{-- Formata a data do request para formado Mês Dia, Ano --}}
		<h1>Searching for posts at {{ \Carbon\Carbon::parse(request('date'))->format('M d, Y') }}</h1>
	</div>
	@if($posts->isEmpty())
		<div class="h-100 flex justify-center items-center">
			<h1 class="text-4xl font-bold">It wasn't found any posts at {{ \Carbon\Carbon::parse(request('date'))->format('M d, Y') }}!</h1>
		</div>
	@else
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
