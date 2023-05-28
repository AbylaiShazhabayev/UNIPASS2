@extends('auth.template')

@section('content')
<div class="container" id="container">
    <div class="form-container sign-in-container d-flex justify-content-center">
        <form id="formLogin" role="form" action="{{ url('/login') }}" method="POST">
            <h1>Sign in</h1>
            <br>
            @if (isset($status))
            <div class="alert alert-success alert-dismissible" role="alert">
                {!! $status !!}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            @if (session()->has('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {!! session()->get('status') !!}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible" role="alert">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif
            <input type="email" name="email" id="txtEmail" autocomplete="off" required
                   value="{{ old('email') }}" placeholder="Email" tabindex="1">
            <input type="password" placeholder="Password" name="password" id="txtPassword" autocomplete="off" required
                   tabindex="2">
            <a href="#">Forgot your password?</a>
            <button type="submit"><i class="fas fa-door-open"></i> Sign in</button>
            <div class="text-center text-muted pt-4">
                Don't have an account yet? <a href="{{ url('register') }}">Sign up</a>
            </div>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
            </div>
            <div class="overlay-panel overlay-right">
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        if ($('#txtEmail').val() != '') {
            $('#txtPassword').focus();
        } else {
            $('#txtEmail').focus();
        }
        $('#formLogin').validate();
    });
</script>
</div>


@endsection
