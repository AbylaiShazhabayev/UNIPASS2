@extends('auth.template')

@section('content')
    <form id="formResetar" class="card card-md" role="form" method="POST" action="{{ url('/password/reset') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ isset($token) ? $token : '' }}">
        <input type="hidden" name="email" value="{{ isset($email) ? $email : '' }}">

        <div class="card-body">
            @if (isset($status))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {!! $status !!}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label" for="txtSenha">Enter your new password</label>
                <input type="password" class="form-control" name="password" required minlength="6" id="txtSenha">
            </div>
            <div class="mb-2">
                <label class="form-label" for="txtRepetirSenha">Repeat your new password</label>
                <input type="password" class="form-control" name="password_confirmation" id="txtRepetirSenha"
                       equalTo="#txtSenha">
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary btn-block">Change Password</button>
            </div>
        </div>
    </form>
    <div class="text-center text-muted">
        Remember your password? <a href="{{ url('login') }}">Access account</a>
    </div>

    <script type="text/javascript">
        $(function () {
            $('#txtSenha').focus();
            $('#formResetar').validate();
        });
    </script>
@endsection
