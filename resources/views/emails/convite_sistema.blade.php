@extends('emails.template')

@section('container')
    <h1>You were invited</h1>
    <hr>
    <p>Hey {{ $convidado }}.</p>
    <p>You were invited by<b>{{ $name }}</b> to use the system {{ config('app.name') }}.</p>
    <cite>{{ config('app.name') }} is a Password Management system that aims to organize and facilitate the sharing of passwords.</cite>
    <p></p>
    <p>To create your system access password, click the button below:</p>
    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
        <tr>
            <td align="left">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td> <a href="{{ url('/password/create/' . $token) }}" target="_blank">Create my password</a> </td>
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
