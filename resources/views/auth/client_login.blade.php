@extends('layouts.login_layout')



@section('title','Client Login')



@section('content')
<style>
@media screen and (max-device-width: 360px) {
	#login-form {
    width: 314px !important;
}
}
</style>
<div id="login-form" class="login_form">

    <h3>Client {{ __('Login') }}</h3>

    <fieldset>

        <form method="POST" action="{{ route('postClientLogin') }}" aria-label="{{ __('Login') }}" id="loginform">

                        @csrf

                <input id="user_name" type="text" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" name="user_name"  placeholder="Username" value="@if($client_username){{$client_username}}@else{{old('user_name') }}@endif" required autofocus>

                                @if ($errors->has('user_name'))

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $errors->first('user_name') }}</strong>

                                    </span>

                                @endif

                <br>

                <br>

                <input id="user_password" type="password" class="form-control{{ $errors->has('user_password') ? ' is-invalid' : '' }}" name="user_password" placeholder="Password" value="{{ $client_password }}" required>



                                @if ($errors->has('user_password'))

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $errors->first('user_password') }}</strong>

                                    </span>

                                @endif
                <div>
                <input class="form-check-input" type="checkbox" name="remember" id="remember" @if($client_username) {{$client_username ? 'checked' : ''}} @else {{ old('remember') ? 'checked' : '' }}  @endif>



                                    <label class="form-check-label" for="remember">

                                        {{ __('Remember Me') }}

                                    </label><br>
                                </div>
                <input type="submit" value="{{ __('Login') }}">

                <!--<footer class="clearfix">

                    <p><span class="info">?</span><a href="#">Forgot Password</a></p>

                </footer>

                -->

        </form>

    </fieldset>

</div> <!-- end login-form -->

@endsection

