@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
            </div>
        @endif
        <div class="col-sm-6 col-sm-offset-3 text-center">
            <h3>Criar carta</h3>

            <form action="{{ route('certificado.login') }}" action="{{ route('criarCarta')}}" method="post">

                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" name="title" class="form-control" placeholder="Título da sua carta">
                </div>
    
                <div class="form-group">
                    <label>Destinatário</label>
                    <input type="text" name="letter_to" class="form-control"  placeholder="Destinatário">
                </div>

                <div class="form-group">
                    <label>Mensagem</label>
                    <textarea class="form-control" name="content" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-lg btn-primary">Escrever carta</a>
            </form>
        </div>
    </div>
</div>
@endsection
