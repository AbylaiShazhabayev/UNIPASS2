@extends('auth.template')

@section('content')
    <form id="formEmail" class="card card-md" role="form" method="POST" action="{{ url('password/email') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="card-body">
            <h2 class="mb-5 text-center">Forgot password?</h2>

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
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            @endif

            <div class="mb-2">
                <label class="form-label" for="txtEmail">Email address</label>
                <input type="email" class="form-control" name="email" id="txtEmail" autocomplete="off" required>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary btn-block" tabindex="3">Request password reset</button>
            </div>
        </div>
    </form>
    <div class="text-center text-muted"><a href="{{ url('login') }}">Sign in</a></div>

    <script type="text/javascript">
        $(function () {
            $('#txtEmail').focus();
            $('#formEmail').validate();
        });
    </script>
@endsection
