@extends('layouts.app')
@section('content')
    <div style="text-align:center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1>Modifica Utente</h1>
                    <a href="/users">Clicca qui per tornare indietro</a><br><br>
                    <p>Qui puoi assegnare il ruolo:</p>
                    <p>Attualmente {{ $user->name }} è un
                    @if($user->role==2)studente
                    @elseif($user->role==1)docente
                    @elseif($user->role==0)amministratore
                    @endif
                    </p>
                    <form action="/users/{{ $user->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label for="role">Ruolo:</label>
                        <select name="role" id="role">
                            <option value="2">Studente</option>
                            <option value="1">Docente</option>
                            <option value="0">Amministratore</option>
                        </select>
                        <input type="submit" class="btn btn-primary" value="Conferma">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection