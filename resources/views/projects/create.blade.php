@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <h1>Creazione progetto:</h1>
    <a href="/users/{{ Auth::user()->id }}/projects/">Torna ai progetti</a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <br>
                <p>Seleziona un corso dal menù e scrivi un primo messaggio per il docente</p>
                <form action="/users/{{ Auth::user()->id }}/projects" method="post">
                    @csrf
                    <label for="course">Scegli un corso:</label>
                    <select name="course" id="course">
                        @foreach($userCourses as $userCourse)
                        <option value={{ $userCourse->id }}>{{ $userCourse->name }}</option>
                        @endforeach
                    </select>
                    <br><br>
                    <label for="message">Aggiungi un messaggio:</label>
                    <br>
                    <div>
                    <textarea name="message" id="message" class="container" rows=10 placeholder="Scrivi un messaggio..."></textarea>
                    </div>
                    <br>
                    <p>Premendo "Invia" si aprirà la pagina del progetto con il messaggio appena creato.</p>
                    <input type="submit" class="btn btn-primary" value="Invia">
                </form>
                <p style="color:red">@error('message'){{ $message="Il messaggio non può essere vuoto." }}@enderror</p>
            </div>
        </div>
    </div>
</div>
@endsection