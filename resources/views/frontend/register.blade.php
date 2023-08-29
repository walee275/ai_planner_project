@extends('layouts.frontend.main')

@section('title', 'Registeration page')

@section('styles')
    <style>

    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col text-center" style="padding: 20px;">
            <h2 class=" text-center">Register</h2>

            {{-- <a href="{{ route('show.plans') }}" class="mb-3 btn d-block">See All Plans</a> --}}
            <form action="{{ route('register') }}" class="text-center m-auto" method="POST">
                @csrf
                <input type="text" class="form-control mb-2 ml-5 w-75 @error('name') is-invalid @enderror" style="margin: auto;" name="name" id="name" value="{{ old('name') }}" placeholder="Enter your Full Name">
                @error('name')
                <p class="text-danger"> {{ $message }}</p>
                @enderror
                <input type="email" class="form-control mb-2 ml-5 w-75 @error('email') is-invalid @enderror" style="margin: auto;" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email">
                @error('email')
                <p class="text-danger"> {{ $message }}</p>
                @enderror
                <input type="password" class="form-control mb-2 w-75 ml-5 @error('password') is-invalid @enderror" style="margin: auto;" name="password" id="password" value="" placeholder="Enter your password">
                @error('password')
                <p class="text-danger"> {{ $message }}</p>
                @enderror
                <p>Already have an account? <a href="{{ route('login') }}" class="text-white">login here</a></p>
                <button type="submit" class="btn ">Register</button>
            </form>

            {{-- <a href="{{ route('create.plan') }}" class="mb-3 btn d-block">Create New Plan</a> --}}
        </div>
    </div>
@endsection





@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
