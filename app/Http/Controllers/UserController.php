<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function login(Request $request)
    {
        $request->validate([
            "email" => 'required|email',
            "password" => 'required|string',
        ], [
            "email.unique" => "El usuario ya ha sido creado",
            "email.required" => 'El correo electronico es obligatorio.',
            "email.email" => 'El correo electronico debe ser una dirección de correo válida.',
            "password.required" => 'La contrasena es obligatoria.',
            "password.password" => 'La contrasena debe ser válida.',
        ]);

        if ( !Auth::attempt(['email'=> $request->email,'password'=> $request->password])){
            return response()->json([
                'message' => 'Error al iniciar sesion',
                'success' => false

            ],500);
        }
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Usuario autenticado correctamente',
            'success' => true,
            'user' => Auth::user()

        ],200);

    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
       

        return response()->json([
            'message' => 'Cierre de sesión exitoso.',
            'success' => true
        ], 200);
    }
    public function registerUser(Request $request)
    {


        $request->validate([
            "email" => 'required|email|unique:users',
            "password" => 'required|string',
            "is_admin" => "boolean|required",
            "name" => 'required|string|max:20'
        ], [
            "email.unique" => "El usuario ya ha sido creado",
            "email.required" => 'El correo electronico es obligatorio.',
            "email.email" => 'El correo electronico debe ser una dirección de correo válida.',
            "password.required" => 'La contrasena es obligatoria.',
            "password.password" => 'La contrasena debe ser válida.',
            "is_admin.boolean" => 'El campo de administrador debe ser verdadero o falso.',
            "is_admin.required" => 'El campo de administrador es obligatorio.'
        ]);

        $newUser = new User();
        $newUser->email = $request->email;
        $newUser->password = $request->password;
        $newUser->is_admin = $request->is_admin;
        $newUser->name = $request->name;

        if ($newUser->save()) {
            // $token = $newUser->createToken('auth_token')->plainTextToken;
            Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado exitosamente.',
                'user' => Auth::user()
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el usuario.'
            ], 500); // Código de estado 500 para error del servidor
        }



        return response()->json($request->all());
    }
}
