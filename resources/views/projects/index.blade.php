@extends('layouts.app')
@section('content')
<div style="text-align:center">
    @if(Auth::user()->role==2)
    <h1>I tuoi progetti:</h1>
    <a href="\home">Torna alla home</a>
    <br><br>
    <p>Clicca su uno dei progetti per accedere ai tuoi allegati</p>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="/users/{{ Auth::user()->id }}/projects/create">Clicca qui per aggiungere un nuovo progetto</a>
                    </div>
                </div>
                <br>
                @forelse($projects as $project)
                <div class="card">
                        <div class="card-body">
                            <a href="/projects/{{ $project->id }}/attachments">
                                Corso: {{ $project->course->name }} - Numero progetto: {{ $project->id }}
                            </a>
                        </div>
                    </div>
                @empty
                    <li>
                        Non ci sono progetti da mostrare.
                    </li>
                @endforelse
            </div>

            {{-- </ul> --}}
    @elseif(Auth::user()->role==1)
    <h1>Progetti degli studenti del corso:</h1>
            <ul>
                @forelse($projects as $project)
                    <li>
                        Corso: {{ $project->course }} - Numero progetto: {{ $project->id }} - Studente: {{ $project->student }}- Matricola - {{ $project->student }} 
                        <a href="/projects/{{ $project->id }}/attachments">Mostra allegati</a>
                    </li>
                @empty
                    <li>
                        Non ci sono progetti da mostrare.
                    </li>
                @endforelse
            </ul>
    @endforelse
</div>
@endsection