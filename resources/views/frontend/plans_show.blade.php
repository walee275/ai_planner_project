@extends('layouts.frontend.main')

@section('title', 'Plans page')

@section('styles')
    <style>
        .tasks-list-container {
            width: 104%;
            height: 271px;
            border: 1px solid #b0d5de;
            border-radius: 12px;
            background: aliceblue;
            max-height: 100%;
            overflow-y: auto;
            margin: auto;
            padding: 5px;
        }
    </style>
@endsection

@section('content')

<div class="row">
    <div class="col " style="text-align: end;">
        <a href="{{ route('homepage') }}" class="btn">Back</a>
    </div>
</div>
    <div class="row">

        <div class="col text-center">


            @if (count($plans))
                @foreach ($plans as $plan)
                    <h4>{{ $plan->title }}</h4>
                    <div class="tasks-list-container">
                        @if (count($plan->tasks))
                            @foreach ($plan->tasks as $task)
                            <div class="d-flex justify-between">
                                <span>{{ $task->created_at->format('Y-m-d,H:i:s') }}</span>
                                <span class="ml-5"> {{ $task->title }}</span>
                            </div>
                        @endforeach
                        @else
                        {!! $plan->description !!}
                        @endif

                    </div>
                @endforeach
            @else
            <div class="row">
                <div class="col text-center">
                    <p class="text-white">No Plans Found</p>

                </div>
            </div>
            @endif
        </div>
    </div>
@endsection





@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
