@extends('layouts.app')

@section('content')
<div class="mt-4 mb-5">
    <form method="post" action="{{ route('url-request.crawler') }}">
        <!-- CROSS Site Request Forgery Protection -->
        @csrf
        <div class="form-group">
            <div class="alert alert-warning" role="alert">
                <strong>Please be patient!</strong><br>
                It might take up a while to process the request. Thank you for your cooperation
            </div>
            <label for="url"><b>Please enter an https:// URL:</b></label>
            <input type="url"
                class="mt-2 mb-2 form-control {{ $errors->has('url') ? 'is-invalid' : '' }}"
                name="url"
                id="url"
                pattern="https?://.+"
                placeholder="https://..."
                value="{{ old('url') }}"
                required
            />
            <!-- Error -->
            @if ($errors->has('url'))
            <div class="invalid-feedback">
                {{ $errors->first('url') }}
            </div>
            @endif
        </div>
        <button type="submit" name="send" value="Discover" class="btn btn-outline-primary">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            Discover
        </button>
    </form>
</div>
@endsection