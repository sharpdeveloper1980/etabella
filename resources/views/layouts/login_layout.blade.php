<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - eTabella</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('public/frontend/css/login.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
   <!-- SWEET ALERT-->
<script src="{{ asset('public/backend/vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        {!! Toastr::message() !!}

    <script type="text/javascript">
      var baseurl = "{{url('/')}}";
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}','Error',{
                    "debug": false,
                });
            @endforeach
        @endif
    localStorage.setItem("job_popup", 0);
    </script> 
</html>
