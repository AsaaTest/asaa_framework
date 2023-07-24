<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Asaa\Http\Request;
use Asaa\Crypto\Hasher;
use Asaa\Http\Controller;

/**
 * Clase AuthenticateController
 * 
 * Esta clase es responsable de manejar la autenticación de usuarios en la aplicación.
 * Contiene métodos para mostrar formularios de registro y inicio de sesión, y para
 * procesar los datos enviados por los usuarios al registrarse e iniciar sesión.
 */
class AuthenticateController extends Controller
{

    /**
     * Método register
     * 
     * Muestra el formulario de registro para que los usuarios se registren en la aplicación.
     * 
     * @return string El resultado del renderizado de la vista de registro.
     */
    public function register()
    {
        return view('auth/register');
    }

    /**
     * Método store
     * 
     * Procesa los datos enviados por los usuarios al registrarse en la aplicación.
     * Realiza la validación de los datos y crea un nuevo usuario si los datos son válidos.
     * Luego inicia sesión para el nuevo usuario y redirige a la página de inicio.
     * 
     * @param Request $request La solicitud HTTP que contiene los datos enviados por el usuario.
     * @param Hasher $hasher El objeto Hasher utilizado para cifrar la contraseña del usuario.
     * @return string La URL de redirección después de completar el registro.
     */
    public function store(Request $request, Hasher $hasher)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);

        if ($data['password'] !== $data['confirm_password']) {
            return back()->withErrors(["confirm_password" => ["confirm" => "Las contraseñas no coinciden."]]);
        }

        $data["password"] = $hasher->hash($data["password"]);

        $user = User::create($data);

        $user->login();

        return redirect('/');
    }

    /**
     * Método index
     * 
     * Muestra el formulario de inicio de sesión para que los usuarios inicien sesión en la aplicación.
     * 
     * @return string El resultado del renderizado de la vista de inicio de sesión.
     */
    public function index()
    {
        return view('auth/login');
    }

    /**
     * Método login
     * 
     * Procesa los datos enviados por los usuarios al iniciar sesión en la aplicación.
     * Realiza la validación de los datos y verifica las credenciales del usuario.
     * Si las credenciales son válidas, inicia sesión para el usuario y redirige a la página de inicio.
     * 
     * @param Request $request La solicitud HTTP que contiene los datos enviados por el usuario.
     * @return string La URL de redirección después de iniciar sesión o volver al formulario de inicio de sesión en caso de error.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::firstWhere('email', $data["email"]);

        if (is_null($user) || !app(Hasher::class)->verify($data["password"], $user->password)) {
            return back()->withErrors(["email" => ["email" => "Las credenciales no coinciden."]]);
        }

        $user->login();

        return redirect("/");
    }

    /**
     * Método logout
     * 
     * Cierra la sesión del usuario autenticado y redirige a la página de inicio.
     * 
     * @return string La URL de redirección después de cerrar sesión.
     */
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
