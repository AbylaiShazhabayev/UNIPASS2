@extends('auth.template')

@section('content')
    <div class="card">
        <div class="card-body text-center">
            @if (isset($status))
                <div class="row text-left justify-content-center">
                    <div class="col-6">
                        <div class="alert alert-success alert-dismissable" role="alert">
                            <p class="mb-0">{!! $status !!}</p>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                    </div>
                </div>
            @endif

            <h3 class="mb-6 font-w300">Access your inbox to check your email</h3>

            <div>We send an email to <u>{{ session('email') }}</u>.</div>
            <div>Follow the instructions to verify your email address.</div>

            <div class="mt-6"><small>Email verification helps us ensure that your details are always safe.</small></div>
        </div>
    </div>
    @if (!isset($status))
        <div class="mt-50 text-center"><small>Didn't receive the verification email? <a
                    href="{{ url('register/verify_email/resend') }}">Send again</a></small></div>
    @endif
@endsection
