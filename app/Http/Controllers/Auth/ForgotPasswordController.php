<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Jobs\SendMail;
use DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request) {
        $user = DB::table('users')->select('name', 'email')->where('email', $request->email)->first();

        if (!isset($user)) {
            return back()->withErrors(['error' => 'Não encontramos nenhum usuário com esse endereço de e-mail.']);
        }

        DB::table('password_resets')->where('email', $request->email)->delete();
        $insert = DB::table('password_resets')->insert(
            [
                'email' => $request->email,
                'token' => sha1(Carbon::now()->toDateTimeString()),
                'created_at' => Carbon::now()->toDateTimeString()
            ]
        );

        if (!$insert) {
            return back()->withErrors(['error' => 'Ocorreu algum problema.<br>Tente novamente.']);
        }

        $reset = DB::table('password_resets')->where('email', $request->email)->first();

        if (!isset($reset)) {
            return back()->withErrors(['error' => 'Não encontramos nenhum token para este e-mail.']);
        }

        $this->dispatch(
            new SendMail([
                'template' => 'emails.reset_password',
                'to_name' => $user->name,
                'to_mail' => $user->email,
                'title' => 'Resetar sua senha',
                'name' => $user->name,
                'email' => $user->email,
                'token' => $reset->token
            ])
        );

        return view('auth.passwords.email', [ 'status' => 'The password reset link has been sent to your email.' ]);
    }
}
