@extends('layouts.app')
 
@section('content')
<div class="mt-4 mb-5">
    <div>
        @php
            extract($urlRequest);
        @endphp
        <div class="card mt-3 mb-3">
            <!--  -->
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ $url }}">{{ $website_metadata['title'] }}</a>
                </h5>
                <p class="card-text">
                    <b>Description:&nbsp;</b>{{ $website_metadata['description'] ?? '' }}
                </p>
                <p class="card-text">
                    Published Time:&nbsp;<small class="text-muted">{{ $website_metadata['published_time'] ?? 'Not Found' }}</small>
                    <br>
                    Crawled At:&nbsp;<small class="text-muted">{{ \Carbon\Carbon::createFromTimestamp($created_at)->toDateTimeString() }}</small>
                </p>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Body XML Filename:&nbsp;
                    <small class="text-muted">
                        @if ($website_metadata['body_filename'] != null || $website_metadata['body_filename'] !== "")
                        <a href="{{ $base_url.'/'.$website_metadata['body_filename'] }}" target="_blank">{{ $website_metadata['body_filename'] }}</a>
                        @else
                        Not Found
                        @endif
                    </small>
                </p>
            </div>
            <div class="card-body">
                <img class="card-img-bottom" src="{{ $base_url.'/'.($website_metadata['screenshot_filename'] ?? '') }}">
            </div>
        </div>
    </div>
</div>
@endsection