<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function registration()
    {
        $user_types = config('app.user_type');
        return view('auth.registration', ['user_types' => $user_types]);
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('home')
                ->withSuccess('You have Successfully loggedin');
        }

        return redirect("login")->withSuccess('Opps! You have entered invalid credentials');
    }
    public function postRegistration(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("home",)->withSuccess('Great! You have Successfully logged in');
    }
    public function dashboard()
    {
        $types = config('app.user_type');
        if (Auth::check()) {
            return view('home', ['types' => $types]);
        }


        return view('home', ['types' => $types]);
    }
    public function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => $data['user_type'],

        ]);

        return redirect('home',)->with('success', "Successfully created new user");
    }
    public function logout()
    {
        Auth::logout();

        return Redirect('login');
    }
    public function search(Request $request)
    {

        if (Auth::check()) {


            $search = $request->input('search');

            $names = User::query()
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('user_type', 'LIKE', "%{$search}%")
                ->get();

            if ($names) {
                $number = User::where('user_type', $names[0]->user_type)->count();
            }


            return view('layouts.search',  ['names' => $names, 'number' => $number]);
        } else {
            return view('auth.login',)->with('error', 'Please login');
        }
    }
}
