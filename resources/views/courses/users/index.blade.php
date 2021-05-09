@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <h1>Docenti del corso</h1>
    <a href="/courses/">Clicca qui per tornare indietro.</a><br><br>
    <p>Elenco dei docenti del corso</p>
    <a href="/courses/{{ $course }}/users/create">Clicca qui per aggiungere docenti al corso</a>
    <table border="1" style="margin: 0px auto;"> 
        <tr>
            <td>ID</td>
            <td>Docente</td>
            <td>Rimuovi</td>
        </tr>
        @forelse($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td><a href= "/courses/{{ $course }}/users/{{ $user->id }}/delete">Rimuovi</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection