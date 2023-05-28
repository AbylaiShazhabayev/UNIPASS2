<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $tenant_id;
    protected $tenant_active;
    protected $user_id;
    protected $user_active;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $this->gravarLogAcesso($request);
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        if ($this->tenant_active === 0) {
            return $this->sendFailedLoginResponse($request, 'auth.failed_account_active');
        }

        if ($this->user_active === 0) {
            return $this->sendFailedLoginResponse($request, 'auth.failed_user_active');
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function gravarLogAcesso($request)
    {
        DB::statement('SET @tenant_id=' . Auth::user()->tenant_id);
        $info = $this->getBrowser();
        DB::table('vw_access_log')->insert(
            [
                'tenant_id' => Auth::user()->tenant_id,
                'date' => Carbon::now()->toDateTimeString(),
                'ip' => $request->ip(),
                'browser' => $info['name'] . " " . $info['version'],
                'platform' => $info['platform'],
                'usuario_id' => Auth::user()->id
            ]
        );
    }

    protected function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Desconhecido';
        $platform = 'Desconhecido';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'Linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'Mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'Windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        $ub = "";
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @param string $field
     * @return RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request, $trans = 'auth.failed')
    {
        $errors = [$this->username() => trans($trans)];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $result = DB::select(
            'SELECT
                t.id AS tenant_id,
                t.active AS tenant_active,
                u.id AS user_id,
                u.active AS user_active
            FROM tenants t
            JOIN users u ON (u.tenant_id = t.id)
            WHERE u.email = :email',
            ['email' => $request->email]
        );

        if (isset($result[0])) {
            $this->tenant_id = $result[0]->tenant_id;
            $this->tenant_active = $result[0]->tenant_active;
            $this->user_id = $result[0]->user_id;
            $this->user_active = $result[0]->user_active;
        }

        return array_merge($request->only($this->username(), 'password'), ['tenant_id' => $this->tenant_id, 'active' => 1]);
    }
}
