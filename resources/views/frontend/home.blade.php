@extends('layouts.frontend.main')

@section('title', 'Home page')

@section('styles')
    <style>

    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col text-center" style="padding: 91px;display: flex;align-content: space-around;flex-direction: column;">
            <a href="{{ route('show.plans') }}" class="mb-3 btn d-block">See All Plans</a>
            <a href="{{ route('create.plan') }}" class="mb-3 btn d-block">Create New Plan</a>
        </div>
    </div>
@endsection





@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
