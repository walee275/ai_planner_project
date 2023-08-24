@include('partials.frontend.head')


<body>
    <div class="container">
        {{-- <div class="clouds">
            <img src="{{ asset('CS5285925-02A-BIG-removebg-preview.png') }}" alt="Clouds" width="150">
        </div> --}}


        <div class="mobile-screen " id="mobile_screen_container">
            <div class="row mt-5">
                <div class="col" style="text-align: end;">
                    @if (Auth::user())
                        <a href="{{ route('logout') }}" class="btn">Logout</a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <img src="{{ asset('CS5285925-02A-BIG-removebg-preview.png') }}" alt="Clouds" width="150">

                </div>
            </div>

            @yield('content')


        </div>
    </div>
    @include('partials.frontend.scripts')
</body>

</html>
