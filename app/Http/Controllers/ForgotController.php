<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot');
    }

    public function forgot(ForgotRequest $request)
    {
        if ($data = $request->validated()) {
            $user = User::where(['email' => $data['email']])->first();

            $password = uniqid();
            $user->password = bcrypt($password);
            $user->save();
            Mail::to($user)->send(new ForgotPassword($password));

            return redirect(route('login'));
        }
    }
}
