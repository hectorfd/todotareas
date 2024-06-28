<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:30|unique:users',
            'nombre' => 'nullable|string|max:60',
            'apellido' => 'nullable|string|max:60',
            'telefono' => 'nullable|integer',
            'direccion' => 'required|string|max:100',
            'email' => 'required|string|email|max:60|unique:users',
            'password' => 'required|string|min:6|max:30|confirmed',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // Crear el usuario
        $user = User::create([
            'username' => $request->username,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Autenticar al usuario después del registro
        auth()->login($user);
    
        // Redirigir al usuario a la página de inicio de sesión
        return redirect()->route('login');
 }
}