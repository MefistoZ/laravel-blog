<?php

namespace App\Http\Controllers;

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

    public function logout()
    {
        Auth::logout();
        return redirect(route('home'));
    }
}
