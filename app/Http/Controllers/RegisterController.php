<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function store(Request $request){

        //modificar el request
        $request->request->add(['ci' => Str::slug($request->ci)]);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed|min:6'

        ]);

        //haciendo peticiones desde la vista
        User::create([
            'name' => $request ->name,
            'email' => $request ->email,
            'password' => Hash::make($request ->password)

        ])->each(function($user){
            $user->assignRole('usuario');
        });

        //Autenticas un Usuario
        auth()->attempt($request->only('email','password'));


        //Redireccionar
        return redirect()->route('home');
        //dd($request->get('email'));
    }
}
