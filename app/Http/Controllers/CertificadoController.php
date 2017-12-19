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
        $privkey = array("file:/" . config('trust.priv_key'), "");
        
        $cacert = "file:/" . config('trust.ca_crt');

        $dn = array(
            "countryName" => auth()->user()->country,
            "stateOrProvinceName" => auth()->user()->state,
            "localityName" => auth()->user()->city,
            "organizationName" => auth()->user()->company_name,
            "organizationalUnitName" => auth()->user()->company_unit_name,
            "commonName" => auth()->user()->name,
            "emailAddress" => auth()->user()->email
        );

        $csr = openssl_csr_new($dn, $privkey, array('digest_alg' => 'sha256'));
        
        $x509 = openssl_csr_sign($csr, $cacert, $privkey, 365, array('digest_alg'=>'sha256') );
        
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
