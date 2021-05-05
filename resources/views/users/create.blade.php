@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <h1>Aggiungi Docente:</h1>
    <a href="/home">Torna alla home</a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="/admin/professor" method="post">
                    @csrf
                    <label for="name">Nome del docente:</label>
                    <input type="text" name="name" placeholder="Nome">
                    <select name="course" id="course">
                        @foreach($courses as $course)
                        <option value={{ $course->id }}>{{ $course->id }} - {{ $course->name }}</option>
                        @endforeach
                    </select>
                    <br>
                </form>
                <p style="color:red">@error('message'){{ $message="Il messaggio non può essere vuoto." }}@enderror</p>
            </div>
        </div>
    </div>
</div>
@endsection