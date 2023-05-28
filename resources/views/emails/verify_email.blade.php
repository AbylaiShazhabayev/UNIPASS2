@extends('emails.template')

@section('container')
    <h1>Check your email address</h1>
    <hr>
    <p>Hey {{ $name }}.</p>
    <p>Check your email address so we know it's really you!</p>
    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
        <tr>
            <td align="left">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td> <a href="{{ url('/register/verify_email/' . $token) }}" target="_blank">Check my email</a> </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <br>
    <p>Yours sincerely,<br>Team {{ config('app.name') }}</p>
@endsection
