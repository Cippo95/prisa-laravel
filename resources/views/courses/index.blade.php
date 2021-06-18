@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Corsi</h1>
                <a href="/home">Torna alla home</a>
                <br><br>

                @if(Auth::user()->role==2)
                    <p>Corsi seguiti:</p>
                    <a href="/users/{{ Auth::user()->id }}/courses/create">Per aggiungere un corso clicca qui</a>
                    <br><br>
                        <table class="table table-bordered" style="text-align:left">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome Corso</th>
                                </tr>
                            </thead>
                            @forelse($courses as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td>{{ $course->name }}</td>
                                </tr>
                            @empty
                                <li>
                                    Non ci sono corsi da mostrare.
                                </li>
                                <br>                
                            @endforelse
                        </table>

                @elseif(Auth::user()->role==1)
                    <p>Clicca su uno dei corsi per vedere progetti degli studenti</p>
                    <table class="table table-bordered" style="text-align:left">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome Corso</th>
                        </tr>
                        </thead>
                        @forelse($courses as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td><a href="/courses/{{ $course->id }}/projects">{{ $course->name }}</a></td>
                            </tr>
                        @empty
                            <li>
                                Non ci sono corsi da mostrare.
                            </li>  
                            <br>             
                        @endforelse
                    </table>
    
                @elseif(Auth::user()->role==0)
                    <p>Corsi registrati</p>
                    <a href="/courses/create">Per creare un nuovo corso clicca qui</a>
                    <br><br>
                    <table class="table table-bordered" style="text-align:left">
                        <thead class="thead-light">                        
                        <tr>
                            <th>ID</th>
                            <th>Nome Corso</th>
                            <th>Docenti</th>
                            <th>Elimina</th>
                        </tr>
                        </thead>
                        @forelse($courses as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->name }}</td>
                                <td><a href="/courses/{{ $course->id }}/users">Mostra Docenti</a></td>
                                <td><form action="/courses/{{ $course->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Elimina">
                                </form></td>
                            </tr>
                        @empty
                            <li>
                                Non ci sono corsi da mostrare.
                            </li> 
                            <br>         
                        @endforelse
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection