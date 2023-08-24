@extends('layouts.frontend.main')

@section('title', 'Login page')

@section('styles')
    <style>

    </style>
@endsection

@section('content')

    <div class="row py-5">
        <div class="col text-center" style="padding: 20px;">
            <h2 class="text-center">Login</h2>

            {{-- <a href="{{ route('show.plans') }}" class="mb-3 btn d-block">See All Plans</a> --}}
            <form action="{{ route('login') }}" class="text-center m-auto" method="POST">
                @csrf
                <input type="text" class="form-control mb-2 ml-5 w-75 @error('email') is-invalid @enderror"
                    style="margin: auto;" name="email" id="email" value="{{ old('email') }}"
                    placeholder="Enter your email">
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input type="password" class="form-control mb-2 w-75 ml-5 @error('password') is-invalid @enderror"
                    style="margin: auto;" name="password" id="password" value="" placeholder="Enter your password">
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <p>Haven't registered yet? <a href="{{ route('register') }}" class="text-white">Register</a></p>
                <button type="submit" class="btn ">Login</button>
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
