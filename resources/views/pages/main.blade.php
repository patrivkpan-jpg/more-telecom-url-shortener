@extends('layouts.app-master')
@section('content')
    <div class="container d-flex align-items-center justify-content-center h-100">
        <div class="form-container d-flex align-items-center justify-content-center h-50">
            <div class="d-flex align-items-center justify-content-center">
                <form id="shortenUrlForm" action="{{ route('url.shorten') }}" method="post">
                    <div class="form-group mb-3">
                        <label for="linkInput" class="form-label">Original URL</label>
                        <input type="text" id="linkInput" class="form-control">
                        <span class="error text-danger text-center"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="linkInput" class="form-label">Send the shortened URL to an email?</label>
                        <input type="text" id="emailInput" class="form-control">
                        <span class="error text-danger text-center"></span>
                    </div>
                    <button type="submit" id="submitShortenUrlFormBtn" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @vite(['resources/js/pages/main.js'])
    <script>
        var routes = {
            'base' : "{{ env('APP_URL') }}",
            'shortenUrlRouteName' : "{{ route('url.shorten') }}"
        }
    </script>
@endsection