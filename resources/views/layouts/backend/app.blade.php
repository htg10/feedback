<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {{-- <title>Admin | StarkLikes</title> --}}
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('meta')
    @include('layouts.backend.partials.style')
     <!-- Boxicons for icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


    @yield('style')
</head>

<body data-sidebar="dark" data-layout-mode="light">

    <!-- [ Start: Layout Wrapper ] -->
    <div id="layout-wrapper">
        @include('layouts.backend.partials.header')

        @include('layouts.backend.partials.sidenav')

        <!--[ Main Content ] start -->
        <div class="main-content">
            @yield('content')
            @include('layouts.backend.partials.footer')
        </div>

    </div>
    @php
        $statusMessage = '';
        if (session()->get('success')) {
            $statusMessage = session()->get('success');
        } elseif (session()->get('error')) {
            $statusMessage = session()->get('error');
        } elseif (session()->get('failure')) {
            $statusMessage = session()->get('failure');
        }
    @endphp

    <script type="text/javascript">
        function slug_url(get, id) {
            var data = $.trim(get);
            var string = data.replace(/[^A-Z0-9]/ig, '-')
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes;
            var finalvalue = string.toLowerCase();
            document.getElementById(id).value = finalvalue;
        }

        setTimeout(function() {
            $(".alert").fadeOut();
        }, 3000);
    </script>


    @include('layouts.backend.partials.script')

    @yield('script')
</body>

</html>
