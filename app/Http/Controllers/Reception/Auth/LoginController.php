<?php

namespace App\Http\Controllers\Reception\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:reception', ['except' => ['logout']]);
    }


    public function login()
    {
        return view('reception-view.auth.login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6'
        ]);

        if (auth('reception')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            return redirect()->route('reception.dashboard');
        }

        return redirect()->back()->withInput($request->only('username', 'remember'))
            ->withErrors(['Credentials does not match.']);
    }

    public function logout(Request $request)
    {
        auth('reception')->logout();
        return redirect()->route('reception.auth.login');
    }
}
