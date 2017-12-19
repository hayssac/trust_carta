<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class CertificadoController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $config = array('config'=> "/etc/ssl/openssl.cnf");
        
        $privkey = openssl_pkey_get_private("file://" . config('trust.priv_key'), config('trust.pass'));
        
        $cacert = "file://" . config('trust.ca_crt');

        $dn = array(
            "countryName" => auth()->user()->country,
            "stateOrProvinceName" => auth()->user()->state,
            "localityName" => auth()->user()->city,
            "organizationName" => auth()->user()->company_name,
            "organizationalUnitName" => auth()->user()->company_unit_name,
            "commonName" => auth()->user()->name,
            "emailAddress" => auth()->user()->email
        );

        // Generate a new private (and public) key pair
/*         $privkey_user = openssl_pkey_new(array(
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        )); */

        $privkey_user = openssl_pkey_new($config);

        //$csr = openssl_csr_new($dn, $privkey_user, array('digest_alg' => 'sha256'));
          
        $csr = openssl_csr_new($dn, $privkey_user, $config);        

        //$x509 = openssl_csr_sign($csr, $cacert, $privkey, 365, array('digest_alg'=>'sha256') );
        
        $x509 = openssl_csr_sign($csr, null, $privkey_user, 365, $config );

        $erros = '';
        while (($e = openssl_error_string()) !== false) {
            $erros = $erros . "\n" . $e;
        }

        Log::info($erros);
        
        openssl_x509_export($x509, $certout); 

        return response($certout)
            ->header('Content-type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="certificado.crt"');

    }
}
