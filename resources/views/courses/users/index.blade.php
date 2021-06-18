@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Docenti del corso</h1>
                <a href="/courses">Torna ai corsi</a><br><br>
                <p>Elenco dei docenti del corso</p>
                <a href="/courses/{{ $course }}/users/create">Clicca qui per aggiungere docenti al corso</a>
                <br><br>
                <table class="table table-bordered" style="text-align:left">
                    <thead class="thead-light"> 
                    <tr>   
                        <th>ID</th>
                        <th>Docente</th>
                        <th>Elimina</th>
                    </tr>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td><form action="/courses/{{ $course }}/users/{{ $user->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="Elimina">
                        </form></td>
                    </tr>
                    @empty
                    <li>
                        Non ci sono docenti da mostrare.
                    </li>
                    <br>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>
@endsection