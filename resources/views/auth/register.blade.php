@extends('auth.template')

@section('content')
<div class="container" id="container" style="min-height: 550px; min-width: 60vw">
    <div class="form-container sign-in-container">
        <form id="formRegister" role="form" method="POST" action="{{ url('/register') }}">
            <h1>Sign up</h1>
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
            <input type="text" name="name" id="txtNome" autocomplete="off" required
                   placeholder="Enter your name" tabindex="1">
            <input type="email" name="email" id="txtEmail" autocomplete="off" required
                   value="{{ old('email') }}" placeholder="Email" tabindex="1">
            <input type="password" placeholder="Enter your password" name="password" id="txtPassword" autocomplete="off" required
                   tabindex="2">
            <input type="password" placeholder="Repeat your password" name="password_confirmation" id="txtRepetirSenha" autocomplete="off" required
                   tabindex="2">
            <input type="number" class="form-control" name="active_users_limit" id="txtActiveUsersLimit"
                   autocomplete="off" value="1" required min="1" max="10000">
            <br>
            <button type="submit"><i class="fas fa-door-open"></i> Sign up</button>
            <div class="text-center text-muted pt-4">
                Already have an account? <a href="{{ url('login') }}">Sign in</a>
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
        $('#txtNome').focus();
        $('#formRegister').validate();
    });
</script>
@endsection
