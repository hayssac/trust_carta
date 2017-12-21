<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\User;
use Exception;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginCertificado(Request $request) {
        
        try {
            $certificado = file_get_contents($request->certificado);
            $certificadoLeitura = (openssl_x509_parse($certificado));    
//            $chavePublica = openssl_pkey_get_details(openssl_pkey_get_public($certificado))["key"];
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());                        
        }
 
        $email = $certificadoLeitura["subject"]["emailAddress"];
        $validoDe = $certificadoLeitura["validFrom_time_t"];
        $validoAte = $certificadoLeitura["validTo_time_t"];
        
        if ( time() < $validoDe && time() > $validoAte ) {
            return back()->with('error', 'Certificado vencido');            
        }        

        $usuario = User::where("email", "=", $email)->first();
        
        if (!$usuario || ($usuario && !openssl_x509_check_private_key($certificado, $usuario->pub_key))) {
            return back()->with('error', 'Certificado inválido');
        } 

        $this->guard()->login($usuario);

        return $this->sendLoginResponse($request);        


    }
}
