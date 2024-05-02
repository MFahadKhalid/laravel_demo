<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} - @stack('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/star-png-star-vector-png-transparent-image-2000.png') }}" type="image/x-icon">
    @include('partial.style')
    @stack('styles')
</head>
<body>
    @include('partial.header')
    <div class="container mt-5">
        @yield('content')
    </div>
    @yield('script')
    @stack('scripts')
</body>
</html>
