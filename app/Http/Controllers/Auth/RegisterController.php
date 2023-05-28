<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Tenant;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

//     public function register(Request $request)
//     {
//         $this->validator($request->all())->validate();
//
//         event(new Registered($user = $this->create($request->all())));
//
//         Auth::logout();
//
//         return $this->registered($request, $user) ?: redirect($this->redirectPath());
//     }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:60',
            'email' => 'required|string|email|max:60|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'active_users_limit' => 'required|integer|min:1|max:10000',
        ])->setAttributeNames([
            'name' => 'Name',
            'email' => 'E-mail',
            'password' => 'Password',
            'active_users_limit' => 'Number of users'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();

        try {
            // Cria conta (Tenant)
            $tenant = Tenant::create([
                'name' => $data['name'],
                'price' => Tenant::calculatePrice($data['active_users_limit']),
                'invoice_period' => 1,
                'trial_ends_at' => Carbon::now()->addDays(7),
                'active_users_limit' => $data['active_users_limit'],
                'active' => 1
            ]);

            DB::statement('SET @tenant_id=' . $tenant->id);

            // Cria usuário
            $user = User::create([
                'tenant_id' => $tenant->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'admin' => 1,
                'active' => 1
            ]);

            DB::commit();

//            session([
//                'name' => $user->name,
//                'email' => $user->email
//            ]);
//            $this->sendVerifyEmail();

            return $user;
        } catch (Exception $e) {
            DB::rollback();
            return withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Send email activate account to user
     *
     * @param string $email
     * @return boolean
     */
    protected function sendVerifyEmail()
    {
        $name = session('name');
        $email = session('email');

        if (!$email) {
            return view('auth.login')->withErrors(['error' => 'The email was not found.']);
        }

        DB::table('password_creates')->where('email', $email)->delete();

        $token = sha1(Carbon::now()->toDateTimeString());
        DB::table('password_creates')->insert(
            [
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()->toDateTimeString()
            ]
        );

        $this->dispatch(
            new SendMail([
                'template' => 'emails.verify_email',
                'to_name' => $name,
                'to_mail' => $email,
                'title' => 'Check your email address',
                'name' => $name,
                'token' => $token
            ])
        );
    }

    public function showCreateForm($token)
    {
        $passwordCreate = DB::table('password_creates')->select('email', 'created_at')->where('token', $token)->first();

        if (!isset($passwordCreate)) {
            return view('auth.passwords.create')->withErrors(['error' => 'The token for password creation is invalid.']);
        }

        return view('auth.passwords.create', ['token' => $token, 'email' => $passwordCreate->email]);
    }

    public function createPassword(Request $request)
    {
        $passwordCreate = DB::table('password_creates')->select('email', 'created_at')->where('token', $request->token)->first();

        if (!isset($passwordCreate)) {
            return view('auth.passwords.create')->withErrors(['error' => 'The token for password creation is invalid.']);
        }

        DB::table('users')
            ->where('email', $passwordCreate->email)
            ->update([
                'password' => bcrypt($request->password),
                'active' => 1
            ]);
        DB::table('password_creates')->where('email', $passwordCreate->email)->delete();

        return redirect('login')->with('status', 'Your password has been created.<br><br><strong>You can now access your account.</strong>');
    }

    protected function viewVerifyEmail()
    {
        if (!session('email')) {
            return redirect('/');
        }

        return view('auth.verify_email');
    }

    protected function verifyEmail($token)
    {
        try {
            $data = DB::table('password_creates')->where('token', $token)->first();

            if (!$data) {
                return view('auth.login')->withErrors(['error' => 'Activation token is invalid.']);
            }

            DB::table('users')->where('email', $data->email)->update(['active' => 1]);
            $data = DB::table('users')->where('email', $data->email)->first();

            DB::table('tenants')->where('id', $data->tenant_id)->update(['active' => 1]);

            DB::table('password_creates')->where('token', $token)->delete();

            return redirect('login')->with('status', 'Your email has been verified.');
        } catch (Exception $e) {
            DB::rollback();

            return withErrors(['error' => $e->getMessage()]);
        }
    }

    protected function verifyEmailResend()
    {
        try {
            $this->sendVerifyEmail();

            return view('auth.verify_email', ['status' => 'The verification email has been resent.']);
        } catch (Exception $e) {
            DB::rollback();

            return withErrors(['error' => $e->getMessage()]);
        }
    }
}
