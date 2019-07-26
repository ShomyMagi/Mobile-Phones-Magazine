<!DOCTYPE html>
        @include('components.header')
	@include('components.navigation')
	
        <div class="site-main-container">
                @yield('content')
        </div>

        @include('components.footer')
</html>