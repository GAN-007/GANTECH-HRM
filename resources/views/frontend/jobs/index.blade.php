
@extends('frontend.Layout.master')

@section('title_front','Jobs')

@section('content')
<section class="jumbotron">
    <div class="container">
        <h1 class="h4">{{__('We found')}} {{$job_posts->count()}} {{__('active jobs')}}</h1>
    </div>
</section>
<section>
    <!-- Recent Jobs -->
    <div class="container listings-container">
        <!-- Listing -->
        <div class="row">
            <div class="col-md-9 mt-3">
                @foreach($job_posts as $job_post)
                <div class="job-listing card mb-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{route('jobs.details',$job_post)}}">
                                    <h4>{{$job_post->job_title}}</h4></a>
                                <h6>{{$job_post->Company->company_name ?? ''}}</h6>
                            </div>
                            <div>
                                @if($job_post->job_type == 'full_time')
                                <span class="badge badge-primary">{{__('Full Time')}}</span>
                                @elseif($job_post->job_type == 'part_time')
                                <span class="badge badge-primary">{{__('Part Time')}}</span>
                                @elseif($job_post->job_type == 'internship')
                                <span class="badge badge-primary">{{trans('file.Internship')}}</span>
                                @elseif($job_post->job_type == 'freelance')
                                <span class="badge badge-primary">{{trans('file.Freelance')}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <ul class="list-inline mb-0">
                            <li data-toggle="tooltip" data-placement="top" title="{{$job_post->no_of_vacancy}} {{ __('vacancy') }}"><i class="dripicons-user-group"></i> {{$job_post->no_of_vacancy}}</li>
                            <li data-toggle="tooltip" data-placement="top" title="{{$job_post->min_experience}} {{ __('of experience') }}"><i class="dripicons-calendar"></i> {{$job_post->min_experience}}</li>
                            <li data-toggle="tooltip" data-placement="top" title="{{ __('posted') }} {{$job_post->updated_at->diffForHumans()}}"><i class="dripicons-clock"></i> {{$job_post->updated_at->diffForHumans()}}</li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-md-3 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{trans('file.Category')}}</h5>
                        @foreach($job_categories as $job_category)
                            <a href="{{route('jobs.searchByCategory',$job_category->url)}}">
                                <p class="mb-1 text-muted">{{$job_category->job_category}}</p>
                            </a>
                            <br>
                        @endforeach
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Job Type</h5>
                        @foreach($job_types as $job_type)
                        <a href="{{route('jobs.searchByJobType',$job_type->job_type)}}">
                            <p class="mb-1 text-muted">
                                @if($job_type->job_type == 'full_time')
                                    {{__('Full Time')}}
                                @elseif($job_type->job_type == 'part_time')
                                    {{__('Part Time')}}
                                @elseif($job_type->job_type == 'internship')
                                    {{trans('file.Internship')}}
                                @elseif($job_type->job_type == 'freelance')
                                    {{trans('file.Freelance')}}
                                @endif
                            </p>
                        </a>
                        <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
