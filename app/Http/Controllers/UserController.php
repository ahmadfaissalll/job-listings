<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  // Show Register/Create Form
  public function create()
  {
    return response()->view('users.register');
  }

  public function store(Request $request)
  {
    $formFields = $request->validate([
      'name' => 'required|min:3',
      'email' => ['required', 'email', Rule::unique('users')],
      'password' => 'required|confirmed|min:6',
      'password_confirmation' => 'required', # konfirmasi password
    ], [
      'name.min' => 'Minimal 3 karakter',
      'email.email' => 'Email tidak valid',
      'email.unique' => 'Email sudah ada',
      'password.confirmed' => 'Password dan konfirmasi password harus sama',
      'password.min' => 'Minimal 6 karakter',
    ]);

    unset($formFields['password_confirmation']);

    // hash password
    $formFields['password'] = Hash::make($formFields['password']);

    $user = User::create($formFields);

    // login
    auth()->login($user);

    return redirect('/listings')->with('message', 'User created and logged in');
  }

  // Show Login Form
  public function login()
  {
    return view('users.login');
  }

  // Authenticate User
  public function authenticate(Request $request)
  {
    $formFields = $request->validate([
      'email' => ['required', 'email'],
      'password' => 'required',
    ], [
      'email.email' => 'Email tidak valid',
    ]);

    if ( auth()->attempt($formFields) ) {
      $request->session()->regenerate();

      return redirect('/listings')->with('message', 'Selamat datang kembali ' . auth()->user()->name);
    }

    return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
  }

  // log out
  public function logout(Request $request)
  {
    auth()->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/listings')->with('message', 'You have been logged out');
  }
}
