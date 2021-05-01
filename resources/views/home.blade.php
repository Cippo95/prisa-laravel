@extends('layouts.app')

@section('content')
    <div style="text-align:center">
        <img src="img/unife.png" alt="logo unife" style= "width: 15%; height: 15%;">
        <br><br><br>
        <h1>Benvenuti su PRISA!</h1>
        <br>
        <p>
            <strong>PRISA</strong> è il mio <strong>PR</strong>ogetto d'<strong>I</strong>ngegneria del 
            <strong>S</strong>oftware <strong>A</strong>vanzata. <br>
            Una applicazione web per la gestione dei progetti universitari.
        </p>
        <br>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>
        
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
        
                            {{ __('Sei loggato!') }}
                            <br>
                                @if (Auth::user()->role == '2')
                                    <a href="/projects">Risulti uno studente: clicca qui per controllare i tuoi progetti.</a>
                                @elseif(Auth::user()->role == '1')
                                    <a href="">Risulti un docente: clicca qui per controllare i tuoi corsi.</a>
                                @elseif(Auth::user()->role == '0')
                                    {{ 'Risulti un amministratore!' }}
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection