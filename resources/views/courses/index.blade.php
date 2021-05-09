@extends('layouts.app')
@section('content')
<div style="text-align:center">
    @if(Auth::user()->role==1)
        <h1>Corsi insegnati:</h1>
        <a href="\home">Torna alla home</a>
        <br><br>
        <p>Clicca su uno dei corsi per vedere progetti degli studenti</p>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @forelse($courses as $course)
                    <div class="card">
                            <div class="card-body">
                                <a href="/courses/{{ $course->id }}/projects">{{ $course->name }}</a>
                            </div>
                    </div>
                    @empty
                    <li>
                        Non ci sono corsi da mostrare.
                    </li>                
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @elseif(Auth::user()->role==0)
    <h1>Corsi</h1>
    <a href="/">Clicca qui per tornare alla home</a>
    <br><br>
    <p>Elenco dei corsi:</p>
    <a href="/courses/create">Per creare un nuovo corso clicca qui.</a>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table border="1" style="margin: 0px auto;"> 
                <tr>
                    <td>ID</td>
                    <td>Nome</td>
                    <td>Insegnanti</td>
                    <td>Cancella</td>
                </tr>
                @forelse($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td><a href="/courses/{{ $course->id }}/users">Mostra</a></td>
                    <td><a href= "/courses/{{ $course->id }}/delete">Cancella</a></td>
                </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif
@endsection