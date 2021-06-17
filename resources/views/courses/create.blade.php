@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Creazione Corso</h1>
                <a href="/courses">Torna ai corsi</a>
                <br><br>
                Inserisci il nome del corso:
                <br><br>
                <form action="/courses" method="post">
                    @csrf
                    <label for="name">Nome del corso:</label>
                    <input type="text" name="name">
                    <input type="submit" class="btn btn-primary" value="Conferma">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection