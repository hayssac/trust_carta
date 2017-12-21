<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDF;
use View;

class Letter extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'letter_to', 'letter_from', 'content'
    ]; 

    /**
     * 
     * A letter is written by an user
     */
    public function user() {
        return $this->belongsTo('App\User');
    }   

    /**
     * Export the letter with certification sigh
     *
     * @return void
     */
    public function export($certificado) {
        $view = View::make('letterPage')->with(['letter' => $this]);
        $html = $view->render();

        PDF::SetTitle('Carta');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        // A função funciona somente se o certificado bater com a chave privada do usuário
        PDF::setSignature($certificado, auth()->user()->pub_key);
        
        return PDF::Output('carta_assinada.pdf');

    }

}
