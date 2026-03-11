<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function Register(Request $request){
        $user = new User;
        $user->name= $request->name;
        $user->email= $request->email;
        $user->password= $request->password;
        $user->save();
        return response()->json(["Mensaje" => 'Creado Usuario'],200);

    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Contraseña Incorrecta'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function logout(){
        auth()->logout();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
