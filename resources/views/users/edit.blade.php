@extends('layouts.app')
@section('content')
    <div style="text-align:center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1>Modifica Utente</h1>
                    <a href="/users">Clicca qui per tornare indietro.</a><br><br>
                    <p>Qui puoi assegnare il ruolo:</p>
                    <form action="/users/{{ $user->id }}" method="POST">
                        @csrf
                        <label for="role">Ruolo:</label>
                        <select name="role" id="role">
                            <option value="2">Studente</option>
                            <option value="1">Docente</option>
                        </select>
                        <input type="submit" value="Invia">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection