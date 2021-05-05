@extends('layouts.app')
@section('content')
<div style="text-align:center">
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
@endsection