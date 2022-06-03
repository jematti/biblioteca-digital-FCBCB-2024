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
            'ci'=> 'required|unique:users|min:3|max:30',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed|min:6'

        ]);

        //haciendo peticiones desde la vista
        User::create([
            'name' => $request ->name,
            'ci' => $request->ci,
            'email' => $request ->email,
            'password' => Hash::make($request ->password)

        ]);

        //Autenticas un Usuario
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        //Redireccionar
        return redirect()->route('home');
        //dd($request->get('email'));
    }
}
