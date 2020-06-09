<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="home">
    
    <div id="root" class="page-wrap">

        @include('includes.header')

        <div class="container">
            <div class="content-app">
                     
            @yield('content')

            </div>
        </div><!-- End Container -->

    </div><!-- End Root page-wrap -->

    @include('includes.footer')    
    @include('includes.script') 

</body>
</html>