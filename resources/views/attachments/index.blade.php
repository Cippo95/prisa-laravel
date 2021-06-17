@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <h1>Messaggi del progetto:</h1>
    @if(Auth::user()->role=='2')
        <a href="/users/{{ Auth::user()->id }}/projects/">Torna ai tuoi progetti</a>
    @elseif(Auth::user()->role=='1')
        <a href="/courses/{{ $project->course_id }}/projects">Torna ai progetti del corso</a>
    @endif
    <br><br>
    <p>Progetto numero: {{ $project->id }} - Corso: {{ $project->course->name }}</p>

    @if(Auth::user()->role==1 and $project->status==1)
    <form action="/projects/{{ $project->id }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="concludi" value=0>
        Per definire il progetto come concluso clicca qui: 
        <button type="submit" class="btn btn-info">Concludi Progetto</button>
    </form>
    @endif

    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($attachments as $attachment)
                <div class="card">
                    @if ($attachment->user->role==2)
                    <div class="card-header">STUDENTE:{{ $attachment->user_id}} - {{ $attachment->user->name }} - {{ \Carbon\Carbon::parse($attachment->created_at)->format('H:i:s d/m/Y') }}</div>
                    @else
                    <div class="card-header">DOCENTE: {{ $attachment->user->name }} - {{ \Carbon\Carbon::parse($attachment->created_at)->format('H:i:s d/m/Y') }}</div>
                    @endif
                    <div class="card-body" style="text-align:left">
                        <p class="card-text">{{ $attachment->message }}</p>
                        @if(!is_null($attachment->file_name))
                        <a href="/projects/{{ $project->id }}/attachments/{{ $attachment->file_name }}" class="card-link">{{ $attachment->file_name }}</a>
                        @endif
                    </div>
                </div>
                @endforeach
                <br>
                @if($project->status == 1)
                    <form action="/users/{{ Auth::user()->id }}/projects/{{ $project->id }}/attachments" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="message">Aggiungi un messaggio:</label>
                        <br>
                        <textarea name="message" id="message" class="container" rows=10 placeholder="Scrivi un messaggio..."></textarea>
                        <br><br>
                        Clicca qui per aggiungere un allegato (max 2000KB):
                        <input type="file" name="file"><br><br>
                        <button type="submit" class="btn btn-primary" value="Invia">Invia</button>
                    </form>
                    <p style="color:red">@error('message'){{ $message="Il messaggio non può essere vuoto." }}@enderror</p>
                @else
                    Il progetto è concluso.
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

