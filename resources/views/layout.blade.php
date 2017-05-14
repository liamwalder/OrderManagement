<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
    <head>
        <meta charset="utf-8"/>
        <title>Butchers</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <style>
            .modal:nth-of-type(even) {
                z-index: 1101 !important;
            }
            .modal-backdrop.in:nth-of-type(odd) {
                z-index: 1100 !important;
            }
        </style>
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}" />
    </head>
    <body>
        <div id="wrapper">
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">

                    <div class="logo">
                        <img src="{{ asset(('images/logo.png')) }}" />
                    </div>

                    <ul class="nav in" id="side-menu">
                        <li {{ Request::is('/') ? 'class=active' : null }}>
                            <a href="{{ route('dashboard') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
                        </li>
                        <li {{ Request::is('orders*') ? ' class=active' : null }}>
                            <a href="{{ route('orders.index') }}"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Orders</a>
                        </li>
                        <li{{ Request::is('products*') ? ' class=active' : null }}>
                            <a href="{{ route('products.index') }}"><i class="fa fa-archive" aria-hidden="true"></i> Products</a>
                        </li>
                        <li{{ Request::is('customers*') ? ' class=active' : null }}>
                            <a href="{{ route('customers.index') }}"><i class="fa fa-users" aria-hidden="true"></i> Customers</a>
                        </li>
                    </ul>
                </div>
            </div>
            {{--<nav class="navbar navbar-default navbar-static-top">--}}
                {{--<div class="navbar-header">--}}
                    {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">--}}
                        {{--<span class="sr-only">Toggle navigation</span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                    {{--</button>--}}
                    {{--<a class="navbar-brand" href="http://demo.startlaravel.com/sb-admin-laravel">Order Mangement</a>--}}
                {{--</div>--}}
                {{--<ul class="nav navbar-top-links navbar-right">--}}
                {{--</ul>--}}

            {{--</nav>--}}
            <div id="page-wrapper">
                @yield('content')
            </div>
        </div>
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' };</script>
        <script src="{{ asset('js/app.js') }}"></script>
        @yield('footer_javascript')
    </body>
</html>