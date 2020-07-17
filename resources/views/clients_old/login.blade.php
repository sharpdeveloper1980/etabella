@extends('layouts.login_layout')

@section('title','Login')

@section('content')
<div id="login-form">
    <h3>{{ __('Login') }}</h3>
    <fieldset>
<!--        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" id="loginform"> -->
                    <form method="POST" action="/e_tabella/clients/login" aria-label="{{ __('Login') }}" id="loginform">

                        @csrf
                <input id="user_name" type="text" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" name="user_name" value="{{ old('user_name') }}" placeholder="Username" required autofocus>
                                @if ($errors->has('user_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif
                <br>
                <br>
                <input id="user_password" type="password" class="form-control{{ $errors->has('user_password') ? ' is-invalid' : '' }}" name="user_password" placeholder="Password" required>

                                @if ($errors->has('user_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_password') }}</strong>
                                    </span>
                                @endif
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label><br>
                <input type="submit" value="{{ __('Login') }}">
                <!--<footer class="clearfix">
                    <p><span class="info">?</span><a href="#">Forgot Password</a></p>
                </footer>
                -->
        </form>
    </fieldset>
</div> <!-- end login-form -->
@endsection
