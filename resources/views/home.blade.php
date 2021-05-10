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
                                @if (Auth::user()->role == '2')
                                    {{ __('Benvenuto studente!') }}
                                    <br><br>
                                    <table class="table table-bordered">
                                        <tr><td><a href="/users/{{ Auth::user()->id }}/projects">Clicca qui per controllare i tuoi progetti</a></td></tr>   
                                        <tr><td><a href="/users/{{ Auth::user()->id }}/courses">Clicca qui per controllare i tuoi corsi</a></td></tr>   
                                    </table>
                                @elseif(Auth::user()->role == '1')
                                    {{ __('Benvenuto docente!') }}
                                    <br><br>
                                    <table class="table table-bordered">
                                    <tr><td><a href="/users/{{ Auth::user()->id }}/courses">Clicca qui per controllare i tuoi corsi</a></td></tr>
                                    </table>
                                @elseif(Auth::user()->role == '0')
                                    {{ __('Benvenuto amministratore!') }}
                                    <br><br>
                                    <table class="table table-bordered">
                                        <tr><td><a href="/users">Clicca qui per vedere gli utenti</a></td></tr>
                                        <tr><td><a href="/courses">Clicca qui per vedere i corsi</a></td></tr>
                                    </table>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection