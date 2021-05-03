@extends('layouts.app')

@section('content')
<div style="text-align:center">
    @if(Auth::user()->role==2)
        <h1>Progetti</h1>
            <a href="/users/{{ Auth::user()->id }}/projects/create">Clicca qui per aggiungere un nuovo progetto</a>
            <ul>
                @forelse($projects as $project)
                    <li>
                        {{ $project->id }} {{ $project->student }} {{ $project->course }} 
                        <a href="/projects/{{ $project->id }}/attachments">Mostra allegati</a>
                    </li>
                @empty
                    <li>
                        Non ci sono progetti da mostrare.
                    </li>
                @endforelse
            </ul>
    @elseif(Auth::user()->role==1)
    <h1>Progetti</h1>
            <ul>
                @forelse($projects as $project)
                    <li>
                        {{ $project->id }} {{ $project->student }} {{ $project->course }} 
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