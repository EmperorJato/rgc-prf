@extends('layouts.app')

@section('links')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="overlay">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>
<div class="container">

    <img class="wave" src="{{asset('images/bg.png')}}">

	<div class="container">

        <div class="img">
            <img src="{{asset('images/login-bg.svg')}}">
        </div>
        
		<div class="login-content">
            
			<form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <div class="cent">
                    <img src="{{asset('images/avatar.svg')}}">
                    <h2 class="title">Sign in</h2>
                </div>
				
                <div class="md-form">

                    <i class="fas fa-user prefix"></i>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required>
                    <label for="username">{{ __('Username') }}</label>
            

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <div class="text-center">
                                <strong>{{ $message }}</strong>
                            </div>
                        </span>
                        @enderror
                   
                </div>
                <div class="md-form">

                    <i class="fas fa-lock prefix"></i>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    <label for="password">{{ __('Password') }}</label>
                    
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <div class="text-center">
                            <strong>{{ $message }}</strong>
                        </div>
                    </span>
                    @enderror
                </div>
                
            	<button type="submit" class="btn">
                    {{ __('Login') }}
                </button>
            </form>
        </div>
        
    </div>
      
</div>

@endsection


@section('scripts')
@if(session()->has("error"))
<script type="text/javascript">
    $(function(){
        swal("Login Failed", "Please contact the administrator to access your account. Thank You", "error").then(function(){
            window.location.href = "{{url('/')}}";
        });
    });
</script>
@endif

<script type="text/javascript">
$(window).on('load', function() {
    $(".overlay").fadeOut(200);
});
</script>
@endsection
