@extends('layouts.app')
@section('content')
    <div style="text-align:center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1>Utenti registrati</h1>
                    <a href="/">Clicca qui per tornare alla home</a>
                    <br><br>
                    <p>Elenco degli utenti registrati:</p>
                    <table border="1" style="margin: 0px auto;"> 
                    <tr>
                        <td>ID</td>
                        <td>Nome</td>
                        <td>Ruolo</td>
                        <td>Operazioni</td>
                    </tr>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if( $user->role ==2)Studente
                            @elseif ( $user->role ==1)Docente
                            @elseif ( $user->role ==0)Amministratore
                            @endif
                        </td>
                        <td><a href= "/users/{{ $user->id }}/edit" > Modifica</a> - <a href= "/users/{{ $user->id }}/delete">Cancella</a></td>
                    </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection