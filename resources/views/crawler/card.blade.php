@php
    extract($urlRequest);
@endphp
<div class="card mt-3 mb-3" style="flex-direction:row;align-items:center;">
    <img class="card-img-top"
        style="width:25vw;border-top-right-radius:0;border-bottom-left-radius:calc(0.25rem - 1px);"
        src="{{ $base_url.'/'.($website_metadata['screenshot_filename'] ?? '') }}">
    <div class="card-body" style="width:75vw;">
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
        <a href="{{ route('url-request.detail', $hid) }}" class="card-link text-info text-opacity-50">MORE DETAIL</a>
    </div>
</div>