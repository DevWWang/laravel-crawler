@extends('layouts.app')
 
@section('content')
<div class="mt-4 mb-5">
    <div>
        @foreach ($urlRequests as $urlRequest)
            @include('crawler.card', ['$urlRequest' => $urlRequest])
        @endforeach
    </div>
</div>
@endsection