@extends('layouts.frontend.main')

@section('title', 'Home page')

@section('styles')
    <style>

    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col d-flex flex-column justify-content-center align-items-center" style="">
            <a href="{{ route('show.plans') }}" class="mb-3 btn ">See All Plans</a>
            <a href="{{ route('create.plan') }}" class="mb-3 btn ">Create New Plan</a>
        </div>
    </div>
@endsection





@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
