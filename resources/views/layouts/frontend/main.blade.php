@include('partials.frontend.head')


<body>
    <div class="container">
        {{-- <div class="clouds">
            <img src="{{ asset('CS5285925-02A-BIG-removebg-preview.png') }}" alt="Clouds" width="150">
        </div> --}}


        <div class="mobile-screen " id="mobile_screen_container">
            {{-- <div class="row mt-">
                <div class="col text-right" style="">
                    @if (Auth::user())
                    <div class="dropdown mt-5 ">
                        <button class="btn dropdown-toggle"  type="button" id="menuToggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="min-width: 67px;" aria-labelledby="menuToggle">
                            @if (Auth::user())
                                <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                                <a href="{{ route('homepage') }}" class="dropdown-item">HomePage</a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div> --}}
            <div class="row">
                <div class="col text-center">
                    <img class="" src="{{ asset('clouds.png') }}" alt="Clouds" style="width:200px;">
                </div>
            </div>

            @yield('content')


        </div>
    </div>
    @include('partials.frontend.scripts')
</body>

</html>
