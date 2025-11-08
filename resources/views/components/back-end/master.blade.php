@include('components.back-end.header')

@include('components.back-end.sidebar')

{{-- @include('components.back-end.navbar') --}}

@include('components.back-end.content')
<main>
    @yield('content')
</main>

@include('components.back-end.footer')