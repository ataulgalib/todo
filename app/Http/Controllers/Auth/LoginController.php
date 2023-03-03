<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Core\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Core\LoginProcessService;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    private $login_process_object;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LoginProcessService $login_process_object, User $user)
    {
        $this->middleware('guest')->except('logout','showLoginForm');
        $this->login_process_object = $login_process_object;
        $this->login_process_object->model = $user;
        $this->redirectTo = config('configuration.APP_ADMIN_REDIRECTION_URL').'/'.RouteServiceProvider::HOME;
    }

    public function showLoginForm()
    {

        if(checkUrl(config('configuration.APP_ADMIN_URL_PREFIX')))
        {
            return view('auth.login');
        }

        return redirect()->route('admin.login');

    }

    public function login(UserLoginRequest $request){

        $data = [
            'credentials' => $request->only('name', 'password'),
            'remember_me' => $request->has('remember') ? true : false,
        ];

        $response = $this->login_process_object->loginProcess($data);

        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));

        if($response['status'] == config('configuration.software_exception_code.success')){
            return redirect()->route('admin.dashboard');
                            // ->withSuccess(__('Login Successfully'));
        }

        if($response['status'] == config('configuration.software_exception_code.fail')){
            return redirect()->back()->withInput($request->only('name','email'))->withErrors([
                'name' => __('These credentials do not match our records.'),
            ]);
        }

    }

    public function logout(Request $request)
    {
        $response = $this->login_process_object->logoutProcess($request);

        logCreate($response, getLogTypeName($response[STATUS_CODE_KEY]));

        if($response['status'] == config('configuration.software_exception_code.success')){
            return redirect()->route('admin.login')->withSuccess(__('messages.logout_success'));
        }

        if($response['status'] == config('configuration.software_exception_code.fail')){
            return redirect()->back();
        }

    }
}
