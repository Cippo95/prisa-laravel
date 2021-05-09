@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <h1>Creazione Corso</h1>
        <a href="/courses">Per tornare ai corsi clicca qui.</a>
        <br><br>
        Inserisci il nome del corso:
        <br><br>
        <form action="/courses" method="post">
            @csrf
            <label for="name">Nome del corso:</label>
            <input type="text" name="name">
            <input type="submit" value="Invia">
        </form>
</div>
@endsection