@extends('layouts.app')
 
@section('content')
<div class="mt-4 mb-5">
    <div>
        <div class="form-group">
            <input type="url"
                class="form-control"
                placeholder="{{ $urlRequest['url'] ?? 'https://' }}"
                readonly>
        </div>
        @include('crawler.card', ['$urlRequest' => $urlRequest])
    </div>
</div>
@endsection