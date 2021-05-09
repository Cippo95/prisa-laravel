@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <h1>Assegnamento Corso a Docente</h1>
    <a href="/courses/{{ $course }}/users">Clicca qui per tornare indietro</a><br><br>
    <p>Scegli il docente del corso:</p>
            <form action="/courses/{{ $course }}/users" method="POST">
                @csrf
                <select name="user" id="user">
                    @foreach ($users as $user)
                        <option value={{ $user->id }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                <input type="submit" value="Conferma">
            </form> 
</div>
@endsection