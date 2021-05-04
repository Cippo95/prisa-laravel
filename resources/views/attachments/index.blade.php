@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <h1>Messaggi del progetto:</h1>
    <a href="/users/{{ Auth::user()->id }}/projects/">Torna ai progetti</a>
    <br><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($attachments as $attachment)
                <div class="card">
                    @if ($attachment->user->role==2)
                    <div class="card-header">STUDENTE:{{ $attachment->user_id}} - {{ $attachment->user->name }} - {{ \Carbon\Carbon::parse($attachment->created_at)->format('h:m:i d/m/Y') }}</div>
                    @else
                    <div class="card-header">DOCENTE: {{ $attachment->user->name }} - {{ \Carbon\Carbon::parse($attachment->created_at)->format('h:m:i d/m/Y') }}</div>
                    @endif
                    <div class="card-body" style="text-align:left">{{ $attachment->message }}</div>
                </div>
                @endforeach
                <br>
                <form action="/users/{{ Auth::user()->id }}/projects/{{ $project_id }}/attachments" method="post">
                    @csrf
                    <label for="message">Aggiungi un messaggio:</label>
                    <br>
                    <textarea name="message" id="message" class="container" rows=10 placeholder="Scrivi un messaggio..."></textarea>
                    <br>
                    <input type="submit" value="Invia">
                </form>
                <p style="color:red">@error('message'){{ $message="Il messaggio non può essere vuoto." }}@enderror</p>
            </div>
        </div>
    </div>
</div>
@endsection

