<!doctype html>
<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        @include('admin.includes.links')
        <title>SKT | @yield('page_title')</title>

    </head>
    <body class="dash_body">  
    <div class="overlay-wrapper">
        <div class="spinner"></div>
    </div>
    <div class="page-container">

        @include('admin.includes.sidebar')

        <div class="main-content" style="min-height:225px;">  
            @include('admin.includes.header')
            @yield('content')
            
        </div> 
    </div>
        @yield('modals')
    
        <!-- @include('admin.includes.footer') -->

        @include('admin.includes.bottom-links')

        @yield('delscript')

    </body>
</html>
