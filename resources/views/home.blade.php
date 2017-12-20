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
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Você está autenticado!
                    
                </div>
            </div>
            <a href="{{ route('gerar') }}" class="btn btn-lg btn-info">Gerar certificado</a>
        </div>
    </div>
</div>
@endsection
