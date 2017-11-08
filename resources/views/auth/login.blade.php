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
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}" />
    </head>
    <body>
        <div id="wrapper" class="login">
            <div id="page-wrapper" >
                <div class="holder">

                    <div class="logo">
                        <img src={{ asset('images/logo.png') }} />
                    </div>

                    <form method="post" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        @if (count($errors))
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" name="email" value="liamwalder@hotmail.co.uk" />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" value="password" />
                        </div>
                        <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin fa-fw'></i>" class="btn btn-default btn-block green">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' };</script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>