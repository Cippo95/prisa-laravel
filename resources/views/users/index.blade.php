@extends('layouts.app')
@section('content')
    <div style="text-align:center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1>Utenti registrati</h1>
                    <a href="/home">Torna alla home</a>
                    <br><br>
                    <p>Elenco degli utenti registrati:</p>
                    <table class="table table-bordered" style="text-align:left">
                    <thead class="thead-light">                    
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ruolo</th>
                        <th>Modifica Ruolo</th>
                        <th>Elimina</th>
                    </tr>
                    </thead>
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
                        <td><a href= "/users/{{ $user->id }}/edit">Modifica Ruolo</a></td>
                        <td><form action="/users/{{ $user->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="Elimina">
                        </form></td>
                    </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection