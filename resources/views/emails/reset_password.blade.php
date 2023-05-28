@extends('emails.template')

@section('container')
    <h1>Don't worry, we all forget sometimes</h1>
    <hr>
    <p>Hey {{ $name }}.</p>
    <p>You recently asked to reset the password for this account:<br>{{ $email }}</p>
    <p>To update your password, click the button below:</p>
    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
        <tr>
            <td align="left">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td> <a href="{{ url('password/reset/' . $token) }}" target="_blank">reset my password</a> </td>
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
