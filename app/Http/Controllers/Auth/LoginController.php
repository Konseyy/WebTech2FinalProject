<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Socialite;
use Auth;


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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function google(){
        return Socialite::driver('google')->redirect();
    }
    public function google_redirect(Request $request){
        $user = Socialite::driver('google')->user();
        $this->registerOrLogin($user);
        return view('home');
    }
    public function facebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function facebook_redirect(){
        $user = Socialite::driver('facebook')->stateless()->user();
        dd($user);
        $this->registerOrLogin($user);
        return redirect()->route('home');
    }
    protected function registerOrLogin($data){
        $user = User::where('email','=',$data->email)->first();
        if(!$user){
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->save();
        }
        Auth::login($user);
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
