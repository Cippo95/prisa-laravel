@extends('layouts.app')

@section('content')
    <div style="text-align:center">
        @include('banner')
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
                                    <a href="/users/{{ Auth::user()->id }}/projects">Risulti uno studente: clicca qui per controllare i tuoi progetti.</a><br>
                                    <a href="/users/{{ Auth::user()->id }}/courses/create">Risulti uno studente: clicca qui per aggiungere un corso che segui.</a>
                                @elseif(Auth::user()->role == '1')
                                    <a href="/users/{{ Auth::user()->id }}/courses">Risulti un docente: clicca qui per controllare i tuoi corsi.</a>
                                @elseif(Auth::user()->role == '0')
                                    {{ 'Risulti un amministratore!' }} 
                                    <br>
                                    <a href="/users">Clicca qui per vedere gli utenti</a><br>
                                    <a href="/courses">Clicca qui per vedere i corsi</a>
                                    {{-- Altri eventuali poteri dell'amministratore da decidere... --}}
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection