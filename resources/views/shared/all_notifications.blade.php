@extends('layout.main')
@section('content')

	<section>
		<div class="container-fluid">
			<div class="card">
				<div class="card-body">

						@foreach($all_notification as $notification)
							<div class="appointment-list-item">
							<a href={{$notification->data['link']}}>{{$notification->data['data']}}</a>
							</div>
						@endforeach

					@if(count($all_notification) > 0)
						<div class="text-center">
							<a href="{{route('clearAll')}}" class="btn btn-link">{{__('Clear All')}}</a>
						</div>
					@else
						<p class="large-text dark-text text-center">{{__('No notifications for you at the moment!')}}</p>
					@endif
				</div>
			</div>
		</div>
	</section>

@endsection
