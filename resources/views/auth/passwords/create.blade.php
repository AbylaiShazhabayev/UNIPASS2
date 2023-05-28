@extends('auth.template')

@section('content')
    <div class="row">
        <div class="col col-login mx-auto">
            <form id="formCriar" class="form-validation card" role="form" method="POST"
                  action="{{ url('/password/create') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="token" value="{{ isset($token) ? $token : '' }}">
                <input type="hidden" name="email" value="{{ isset($email) ? $email : '' }}">

                <div class="card-body p-6">
                    <div class="card-title">Create access password</div>

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

                    <div class="form-group">
                        <label class="form-label" for="txtSenha">Type your password</label>
                        <input type="password" class="form-control" name="password" required minlength="6" id="txtSenha">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="txtRepetirSenha">Repeat your password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="txtRepetirSenha"
                               equalTo="#txtSenha">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Create password</button>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            $('#txtSenha').focus();
            $('#formCriar').validate();
        });
    </script>
@endsection
