<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Метод для регистрации и последующей авторизации пользователя
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            //unique - после двоеточия указывается сущность и через запятую поле которое должно проверятся на уникальность
            'email' => ['required', 'email', 'string', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::create([
           'name' => $data['name'],
           'email' => $data['email'],
           'password' => bcrypt($data['password']),
        ]);

        if ($user) {
            auth('web')->login($user);
        }

        return redirect(route('home'));
    }

    /**
     * Метод разлогинивает пользователя
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('home'));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'string'],
            'password' => ['required'],
        ]);
        if (auth('web')->attempt($data)) {
            return redirect(route('home'));
        }

        return redirect(route('login'))->withErrors([
            'email' => 'Проверьте правильность введённых данных'
        ]);
    }

}
